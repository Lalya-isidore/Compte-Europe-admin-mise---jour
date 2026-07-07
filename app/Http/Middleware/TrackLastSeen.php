<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrackLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Update at most once every 2 minutes to limit DB writes
            if (! $user->last_seen_at || $user->last_seen_at->diffInSeconds(now()) >= 120) {
                DB::table('users')->where('id', $user->id)->update(['last_seen_at' => now()]);
                $user->last_seen_at = now();
            }
        }

        return $next($request);
    }
}
