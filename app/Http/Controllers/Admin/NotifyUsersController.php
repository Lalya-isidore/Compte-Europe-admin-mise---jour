<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\MassNotification;
use App\Models\User;
use App\Models\UserNotification;
use App\Services\SafeMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotifyUsersController extends Controller
{
    public function index(): View
    {
        $usersCount = User::count();
        $afriqueUsersCount = User::where('region', 'afrique')->count();
        $missingPhotoCount = User::whereHas('comptes', function ($q) {
            $q->whereNull('photo_path')->orWhere('photo_path', '');
        })->count();
        $users = User::select('id', 'nom', 'prenom', 'email')->orderBy('nom')->get();

        return view('admin.notify-users', compact('usersCount', 'afriqueUsersCount', 'missingPhotoCount', 'users'));
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type'         => ['required', 'in:email,chat,both'],
            'target'       => ['required', 'in:all,missing_photo,afrique,single'],
            'user_id'      => ['nullable', 'required_if:target,single', 'exists:users,id'],
            'subject'      => ['nullable', 'string', 'max:255'],
            'message'      => ['required', 'string', 'max:10000'],
            'banner_image' => ['nullable', 'image', 'max:5120'],
        ]);

        $type = $data['type'];

        if (in_array($type, ['email', 'both']) && empty($data['subject'])) {
            return back()->withErrors(['subject' => 'Le sujet est requis pour l\'envoi par e-mail.'])->withInput();
        }

        $recipients = $this->resolveRecipients($data['target'], $data['user_id'] ?? null);

        if ($recipients->isEmpty()) {
            return back()->with('error', 'Aucun destinataire trouvé.');
        }

        $count   = $recipients->count();
        $message = $data['message'];
        $list    = $recipients->all();
        $results = [];

        // Envoi par e-mail
        if (in_array($type, ['email', 'both'])) {
            $subject   = $data['subject'];
            $bannerUrl = null;
            if ($request->hasFile('banner_image')) {
                $path      = $request->file('banner_image')->store('email-banners', 'public');
                $bannerUrl = asset('storage/' . $path);
            }

            app()->terminating(function () use ($list, $subject, $message, $bannerUrl) {
                set_time_limit(0);
                foreach ($list as $user) {
                    SafeMailService::send(
                        $user->email,
                        new MassNotification($subject, $message, $user, $bannerUrl),
                        'Notification en masse'
                    );
                }
            });

            $results[] = "{$count} e-mail(s) en cours d'envoi";
        }

        // Envoi dans les notifications in-app (cloche)
        if (in_array($type, ['chat', 'both'])) {
            $title = $data['subject'] ?? null;
            foreach ($list as $user) {
                UserNotification::create([
                    'user_id' => $user->id,
                    'title'   => $title,
                    'message' => $message,
                    'read_at' => null,
                ]);
            }

            $results[] = "{$count} notification(s) envoyées dans la cloche";
        }

        return back()->with('success', '✅ ' . implode(' et ', $results) . '.');
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
            'afrique' => User::where('region', 'afrique')
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->get(),
            'single' => User::where('id', $userId)->get(),
            default => collect(),
        };
    }
}
