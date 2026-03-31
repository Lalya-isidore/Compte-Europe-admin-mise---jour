<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireFeature
{
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        if (!app('region')->hasFeature($feature)) {
            abort(403, 'Cette fonctionnalité n\'est pas disponible dans votre région.');
        }

        return $next($request);
    }
}
