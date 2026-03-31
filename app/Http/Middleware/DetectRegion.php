<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectRegion
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $afriqueDomain = config('regions.afrique.domain');

        if ($afriqueDomain && str_contains($host, $afriqueDomain)) {
            session(['detected_region' => 'afrique']);
        } elseif (!session('detected_region')) {
            session(['detected_region' => 'europe']);
        }

        return $next($request);
    }
}
