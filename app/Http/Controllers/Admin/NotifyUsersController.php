<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\MassNotification;
use App\Models\User;
use App\Services\SafeMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotifyUsersController extends Controller
{
    public function index(): View
    {
        $usersCount = User::count();
        $missingPhotoCount = User::whereHas('comptes', function ($q) {
            $q->whereNull('photo_path')->orWhere('photo_path', '');
        })->count();
        $users = User::select('id', 'nom', 'prenom', 'email')->orderBy('nom')->get();

        return view('admin.notify-users', compact('usersCount', 'missingPhotoCount', 'users'));
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'target' => ['required', 'in:all,missing_photo,single'],
            'user_id' => ['nullable', 'required_if:target,single', 'exists:users,id'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:10000'],
        ]);

        $recipients = $this->resolveRecipients($data['target'], $data['user_id'] ?? null);

        if ($recipients->isEmpty()) {
            return back()->with('error', 'Aucun destinataire trouvé.');
        }

        $count      = $recipients->count();
        $subject    = $data['subject'];
        $message    = $data['message'];
        $list       = $recipients->all();

        // Envoi après que la réponse HTTP soit déjà envoyée au navigateur
        app()->terminating(function () use ($list, $subject, $message) {
            set_time_limit(0);
            foreach ($list as $user) {
                SafeMailService::send(
                    $user->email,
                    new MassNotification($subject, $message, $user),
                    'Notification en masse'
                );
            }
        });

        return back()->with('success', "✅ Envoi lancé : {$count} e-mail(s) en cours de traitement.");
    }

    private function resolveRecipients(string $target, ?int $userId)
    {
        return match ($target) {
            'all' => User::whereNotNull('email')->where('email', '!=', '')->get(),
            'missing_photo' => User::whereNotNull('email')
                ->where('email', '!=', '')
                ->whereHas('comptes', function ($q) {
                    $q->whereNull('photo_path')->orWhere('photo_path', '');
                })
                ->get(),
            'single' => User::where('id', $userId)->get(),
            default => collect(),
        };
    }
}
