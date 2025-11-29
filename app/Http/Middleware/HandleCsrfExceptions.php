<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Session\TokenMismatchException;

class HandleCsrfExceptions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (TokenMismatchException $e) {
            // Si c'est une requête AJAX, retourner du JSON
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'error' => 'Session expirée',
                    'message' => 'Votre session a expiré pour des raisons de sécurité. Veuillez actualiser la page.',
                    'code' => 419,
                    'refresh_needed' => true
                ], 419);
            }

            // Pour les requêtes normales, rediriger vers la page d'erreur 419
            return response()->view('errors.419', [], 419);
        }
    }
}
