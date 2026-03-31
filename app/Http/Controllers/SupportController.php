<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Mail\SupportAdminNotification;
use App\Services\SafeMailService;

class SupportController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $tickets = $user->supportTickets()
            ->withCount('messages')
            ->orderByDesc('updated_at')
            ->get();

        $activeTicket = null;

        if ($tickets->isNotEmpty()) {
            $ticketId = (int) $request->query('ticket');

            if ($ticketId) {
                $activeTicket = $user->supportTickets()
                    ->with(['messages.user' => function ($query) {
                        $query->select('id', 'nom', 'prenom', 'email');
                    }])
                    ->find($ticketId);
            }

            if (! $activeTicket) {
                $activeTicket = $user->supportTickets()
                    ->with(['messages.user' => function ($query) {
                        $query->select('id', 'nom', 'prenom', 'email');
                    }])
                    ->orderByDesc('updated_at')
                    ->first();
            }
        }

        $supportStatus = $this->supportStatus();

        return view('support.index', [
            'tickets' => $tickets,
            'activeTicket' => $activeTicket,
            'supportStatus' => $supportStatus,
            'welcomeMessage' => $supportStatus['welcome_message'],
        ]);
    }

    public function storeTicket(Request $request): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['nullable', 'string', 'max:2000', 'required_without_all:attachment,voice'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx,zip,txt,mp4,mov', 'max:10240'],
            'voice' => ['nullable', 'file', 'mimetypes:audio/mpeg,audio/ogg,audio/wav', 'max:10240'],
        ]);

        $ticket = SupportTicket::create([
            'user_id' => $request->user()->id,
            'subject' => $data['subject'],
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $payload = $this->handleUploads($request);
        $welcomeMessage = config('services.crisp.auto_message', 'Bonjour, posez-moi toutes vos questions à propos de nos services');

        $message = SupportMessage::create(array_merge([
            'support_ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'sent_by_admin' => false,
            'content' => $data['message'] ?? '',
        ], $payload));

        if ($welcomeMessage) {
            SupportMessage::create([
                'support_ticket_id' => $ticket->id,
                'sent_by_admin' => true,
                'content' => $welcomeMessage,
            ]);
        }

        $ticket->touch();

        // Notifier l'admin par email
        $ticket->load('user');
        SafeMailService::send(
            config('mail.admin_email', 'isiserviceplus@gmail.com'),
            new SupportAdminNotification($ticket, $message, 'new_ticket'),
            'Support: nouveau ticket #' . $ticket->id
        );

        if ($request->expectsJson()) {
            $ticket->load(['messages']);

            return response()->json([
                'success' => true,
                'ticket' => $this->formatTicket($ticket),
                'message' => 'Votre message a été transmis. Nous vous répondrons rapidement.',
            ], 201);
        }

        return redirect()
            ->route('support.index', ['ticket' => $ticket->id])
            ->with('success', 'Votre message a été transmis. Nous vous répondrons rapidement.');
    }

    public function storeMessage(Request $request, SupportTicket $ticket): RedirectResponse|JsonResponse
    {
        $this->authorizeTicket($request, $ticket);

        $data = $request->validate([
            'message' => ['nullable', 'string', 'max:2000', 'required_without_all:attachment,voice'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx,zip,txt,mp4,mov', 'max:10240'],
            'voice' => ['nullable', 'file', 'mimetypes:audio/mpeg,audio/ogg,audio/wav', 'max:10240'],
        ]);

        if ($ticket->status === 'closed') {
            $ticket->update(['status' => 'open']);
        }

        $payload = $this->handleUploads($request);

        $message = SupportMessage::create(array_merge([
            'support_ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'sent_by_admin' => false,
            'content' => $data['message'] ?? '',
        ], $payload));

        $ticket->update([
            'last_message_at' => now(),
            'status' => 'pending',
        ]);

        // Notifier l'admin par email
        $ticket->load('user');
        SafeMailService::send(
            config('mail.admin_email', 'isiserviceplus@gmail.com'),
            new SupportAdminNotification($ticket, $message, 'new_message'),
            'Support: nouveau message ticket #' . $ticket->id
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Votre message a été envoyé.',
                'entry' => $this->formatMessage($message),
            ]);
        }

        return redirect()
            ->route('support.index', ['ticket' => $ticket->id])
            ->with('success', 'Votre message a été envoyé.');
    }

    public function widgetData(Request $request): JsonResponse
    {
        $user = $request->user();

        $status = $this->supportStatus();
        $ticket = $user->supportTickets()
            ->with('messages')
            ->orderByDesc('updated_at')
            ->first();

        return response()->json([
            'success' => true,
            'ticket' => $ticket ? $this->formatTicket($ticket) : null,
            'unread_count' => $this->unreadAdminCountForUser($user->id),
            'support_status' => $status,
        ]);
    }

    public function markWidgetRead(Request $request): JsonResponse
    {
        $user = $request->user();

        SupportMessage::whereNull('read_at')
            ->where('sent_by_admin', true)
            ->whereHas('ticket', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->update([
                'read_at' => now(),
                'updated_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'unread_count' => $this->unreadAdminCountForUser($user->id),
        ]);
    }

    protected function authorizeTicket(Request $request, SupportTicket $ticket): void
    {
        if ($ticket->user_id !== $request->user()->id) {
            abort(403, 'Vous ne pouvez pas accéder à cette discussion.');
        }
    }

    protected function unreadAdminCountForUser(int $userId): int
    {
        return SupportMessage::whereNull('read_at')
            ->where('sent_by_admin', true)
            ->whereHas('ticket', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->count();
    }

    protected function formatTicket(SupportTicket $ticket): array
    {
        return [
            'id' => $ticket->id,
            'subject' => $ticket->subject,
            'status' => $ticket->status,
            'created_at' => $ticket->created_at->format('d/m/Y H:i'),
            'messages' => $ticket->messages
                ->sortBy('created_at')
                ->values()
                ->map(fn (SupportMessage $message) => $this->formatMessage($message))
                ->all(),
        ];
    }

    protected function formatMessage(SupportMessage $message): array
    {
        return [
            'id' => $message->id,
            'sent_by_admin' => (bool) $message->sent_by_admin,
            'content' => $message->content,
            'created_at' => $message->created_at->format('d/m/Y H:i'),
            'file_name' => $message->file_name,
            'file_url' => $message->attachment_url,
            'file_type' => $message->file_type,
            'file_size' => $message->file_size,
            'voice_url' => $message->voice_url,
        ];
    }

    protected function handleUploads(Request $request): array
    {
        $payload = [
            'file_name' => null,
            'file_path' => null,
            'file_type' => null,
            'file_size' => null,
            'voice_path' => null,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            // Use explicit public disk write to ensure visibility on restrictive hosts
            $path = Storage::disk('public')->putFile('support/attachments', $file);

            $payload['file_name'] = $file->getClientOriginalName();
            $payload['file_path'] = $path;
            $payload['file_type'] = $file->getClientMimeType();
            $payload['file_size'] = $file->getSize();
        }

        if ($request->hasFile('voice')) {
            $voice = $request->file('voice');
            $payload['voice_path'] = Storage::disk('public')->putFile('support/voices', $voice);

            if (! $payload['file_name']) {
                $payload['file_name'] = $voice->getClientOriginalName() ?: 'enregistrement-vocal.' . $voice->extension();
                $payload['file_type'] = $voice->getClientMimeType();
                $payload['file_size'] = $voice->getSize();
            }
        }

        return $payload;
    }

    protected function supportStatus(): array
    {
        // Ne plus utiliser les messages de la base de données pour déterminer la présence
        // Uniquement utiliser le cache de session admin active
        $cachedActivity = cache()->get('support_admin_last_active');
        if ($cachedActivity && ! $cachedActivity instanceof Carbon) {
            $cachedActivity = Carbon::parse($cachedActivity);
        }
        
        $latestActivity = $cachedActivity; // Uniquement le cache, pas les messages

        $welcome = config('services.crisp.auto_message', 'Bonjour, posez-moi toutes vos questions à propos de nos services');

        return [
            'welcome_message' => $welcome,
            'last_active_at' => $latestActivity,
            'active_message' => $this->formatSupportActivity($latestActivity),
        ];
    }

    protected function formatSupportActivity(?Carbon $activity): string
    {
        if (! $activity) {
            return 'Délai de réponse : 24h maximum';
        }

        $diffInMinutes = now()->diffInMinutes($activity);

        if ($diffInMinutes <= 5) {
            return 'Actif maintenant • Réponse sous 24h';
        }

        if ($diffInMinutes < 60) {
            return 'Actif il y a ' . $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '') . ' • Réponse sous 24h';
        }

        if ($diffInMinutes < 1440) {
            $hours = (int) floor($diffInMinutes / 60);
            return 'Actif il y a ' . $hours . ' heure' . ($hours > 1 ? 's' : '') . ' • Réponse sous 24h';
        }

        return 'Délai de réponse : 24h maximum';
    }
}
