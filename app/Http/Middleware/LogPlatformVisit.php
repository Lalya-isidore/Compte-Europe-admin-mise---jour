<?php

namespace App\Http\Middleware;

use App\Models\PlatformVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogPlatformVisit
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (
            $request->isMethod('GET') &&
            !$request->is('admin/*') &&
            !$request->is('api/*') &&
            !$request->ajax() &&
            Auth::check()
        ) {
            PlatformVisit::create([
                'user_id'    => Auth::id(),
                'ip_address' => $request->ip(),
                'url'        => $request->path(),
            ]);
        }

        return $response;
    }
}
