<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'administrateur est authentifié
        if (!Session::has('admin_authenticated')) {
            // Si ce n'est pas le cas, rediriger vers la page de connexion admin
            return redirect()->route('admin.index')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        // Vérifier que la session n'a pas expiré (optionnel, 2 heures par défaut)
        $loginTime = Session::get('admin_login_time');
        if ($loginTime && now()->diffInHours($loginTime) > 2) {
            Session::forget('admin_authenticated');
            Session::forget('admin_email');
            Session::forget('admin_login_time');
            
            return redirect()->route('admin.index')
                ->with('error', 'Votre session a expiré. Veuillez vous reconnecter.');
        }

        Cache::put('support_admin_last_active', now(), now()->addHours(6));

        return $next($request);
    }
}
