<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    // Administrateurs autorisés (email => mot de passe)
    private const ADMINS = [
        'isiserviceplus@gmail.com' => 'Lalyaisidore1@gmail.com',
    ];

    // Rétrocompatibilité
    private const ADMIN_EMAIL = 'isiserviceplus@gmail.com';
    private const ADMIN_PASSWORD = 'Lalyaisidore1@gmail.com';

    /**
     * Page principale admin - affiche login ou dashboard selon authentification
     */
    public function index()
    {
        // Si déjà connecté en tant qu'admin, afficher le dashboard admin
        if (Session::has('admin_authenticated')) {
            return $this->dashboard();
        }

        // Sinon, afficher la page de connexion
        return view('admin.login');
    }

    /**
     * Afficher la page de connexion admin
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Dashboard admin
     */
    private function dashboard()
    {
        $stats = [
            'users_count' => \App\Models\User::count(),
            'comptes_count' => \App\Models\Compte::count(),
            'commissions_pending' => \App\Models\Commission::whereIn('statut', ['en_attente', 'en_cours_de_retrait'])->count(),
            'support_tickets_open' => \App\Models\SupportTicket::where('status', 'open')->count(),
        ];

        return view('admin.dashboard', [
            'admin_email' => Session::get('admin_email'),
            'login_time' => Session::get('admin_login_time'),
            'stats' => $stats
        ]);
    }

    /**
     * Traiter la tentative de connexion
     */
    public function login(Request $request)
    {
        // Validation des champs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        // Vérification des identifiants
        if (isset(self::ADMINS[$email]) && self::ADMINS[$email] === $password) {
            // Authentification réussie
            Session::put('admin_authenticated', true);
            Session::put('admin_email', $email);
            Session::put('admin_login_time', now());
            Cache::put('support_admin_last_active', now(), now()->addHours(6));

            // Logs de connexion (optionnel)
            Log::info('Connexion administrateur réussie', [
                'email' => $email,
                'ip' => $request->ip(),
                'time' => now()
            ]);

            return redirect()->route('admin.index')
                ->with('success', 'Connexion réussie ! Bienvenue administrateur.');
        }

        // Échec de l'authentification
        Log::warning('Tentative de connexion admin échouée', [
            'email' => $email,
            'ip' => $request->ip(),
            'time' => now()
        ]);

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Identifiants incorrects. Accès refusé.');
    }

    /**
     * Déconnexion de l'administrateur
     */
    public function logout(Request $request)
    {
        Log::info('Déconnexion administrateur', [
            'email' => Session::get('admin_email'),
            'time' => now()
        ]);

        Session::forget('admin_authenticated');
        Session::forget('admin_email');
        Session::forget('admin_login_time');
        
        // Supprimer le cache de présence lors de la déconnexion
        Cache::forget('support_admin_last_active');

        // Déconnecter aussi la session utilisateur
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }


}
