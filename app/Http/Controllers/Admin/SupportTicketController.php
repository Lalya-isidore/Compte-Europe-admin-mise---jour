<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Mail\SupportUserReply;
use App\Services\SafeMailService;

class SupportTicketController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $tickets = SupportTicket::with(['user:id,nom,prenom,email'])
            ->withCount('messages')
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderByDesc('last_message_at')
            ->orderByDesc('updated_at')
            ->paginate(15)
            ->withQueryString();

        $activeTicket = null;

        if ($tickets->isNotEmpty()) {
            $ticketId = (int) $request->query('ticket');

            if ($ticketId) {
                $activeTicket = SupportTicket::with(['user:id,nom,prenom,email', 'messages.user:id,nom,prenom,email'])
                    ->find($ticketId);
            }

            if (! $activeTicket) {
                $activeTicket = SupportTicket::with(['user:id,nom,prenom,email', 'messages.user:id,nom,prenom,email'])
                    ->whereIn('id', $tickets->pluck('id'))
                    ->orderByDesc('last_message_at')
                    ->orderByDesc('updated_at')
                    ->first();
            }
        }

        if ($activeTicket) {
            SupportMessage::where('support_ticket_id', $activeTicket->id)
                ->where('sent_by_admin', false)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return view('admin.support.index', [
            'tickets' => $tickets,
            'activeTicket' => $activeTicket,
            'currentStatus' => $status,
        ]);
    }

    public function reply(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $data = $request->validate([
            'message' => ['nullable', 'string', 'max:2000', 'required_without_all:attachment,voice'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx,zip,txt,mp4,mov', 'max:10240'],
            'voice' => ['nullable', 'file', 'mimetypes:audio/mpeg,audio/ogg,audio/wav', 'max:10240'],
        ]);

        $payload = $this->handleUploads($request);

        $message = SupportMessage::create(array_merge([
            'support_ticket_id' => $ticket->id,
            'sent_by_admin' => true,
            'content' => $data['message'] ?? '',
        ], $payload));

        $ticket->update([
            'status' => 'answered',
            'last_message_at' => now(),
            'updated_at' => now(),
        ]);

        // Notifier l utilisateur par email
        $ticket->load('user');
        if ($ticket->user && $ticket->user->email) {
            SafeMailService::send(
                $ticket->user->email,
                new SupportUserReply($ticket, $message),
                'Support: reponse ticket #' . $ticket->id
            );
        }

        return redirect()
            ->route('admin.support.index', ['ticket' => $ticket->id])
            ->with('success', 'Reponse envoyee.');
    }

    public function updateStatus(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:open,pending,answered,closed'],
        ]);

        $ticket->update([
            'status' => $data['status'],
        ]);

        return redirect()
            ->route('admin.support.index', ['ticket' => $ticket->id])
            ->with('success', 'Statut de la demande mis a jour.');
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

    public function unreadCount(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'count' => SupportMessage::where('sent_by_admin', false)
                ->whereNull('read_at')
                ->count(),
        ]);
    }

    public function poll(Request $request, SupportTicket $ticket): JsonResponse
    {
        $sinceId = (int) $request->query('since', 0);

        $messages = SupportMessage::with(['user:id,nom,prenom'])
            ->where('support_ticket_id', $ticket->id)
            ->where('id', '>', $sinceId)
            ->orderBy('id')
            ->get();

        if ($messages->where('sent_by_admin', false)->isNotEmpty()) {
            SupportMessage::where('support_ticket_id', $ticket->id)
                ->where('sent_by_admin', false)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return response()->json([
            'messages' => $messages->map(fn($msg) => [
                'id'            => $msg->id,
                'content'       => $msg->content,
                'sent_by_admin' => (bool) $msg->sent_by_admin,
                'time'          => $msg->created_at->setTimezone('Europe/Paris')->format('H:i'),
                'read_at'       => $msg->read_at ? $msg->read_at->setTimezone('Europe/Paris')->format('d/m/Y à H:i') : null,
                'file_url'      => $msg->file_path ? asset('storage/' . $msg->file_path) : null,
                'file_type'     => $msg->file_type,
                'file_name'     => $msg->file_name,
                'voice_url'     => $msg->voice_path ? asset('storage/' . $msg->voice_path) : null,
                'user_name'     => $msg->user ? $msg->user->nom : 'Client',
            ]),
            'ticket_status' => $ticket->status,
        ]);
    }
}
