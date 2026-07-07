<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\DetectRegion::class,
            \App\Http\Middleware\LogPlatformVisit::class,
            \App\Http\Middleware\TrackLastSeen::class,
        ]);

        $middleware->alias([
            'feature' => \App\Http\Middleware\RequireFeature::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Gestion globale des erreurs - redirection avec message au lieu de pages d'erreur
        // Affichage natif des erreurs Laravel (debug)
        // Les erreurs ne sont plus interceptées ni redirigées, pour voir les détails natifs Laravel
    })->create();
