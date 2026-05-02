<?php

namespace App\Http\Middleware;

use App\Models\PlatformVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
            Auth::check() &&
            !session()->has('visit_logged')
        ) {
            $ip = $request->ip();
            $location = $this->getLocation($ip);

            PlatformVisit::create([
                'user_id'    => Auth::id(),
                'ip_address' => $ip,
                'location'   => $location,
                'url'        => $request->path(),
            ]);
            session(['visit_logged' => true]);
        }

        return $response;
    }

    private function getLocation(string $ip): ?string
    {
        // IPs locales/privées
        if (in_array($ip, ['127.0.0.1', '::1']) || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return 'Local';
        }

        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=city,country&lang=fr");
            if ($response->successful()) {
                $data = $response->json();
                $city    = $data['city'] ?? '';
                $country = $data['country'] ?? '';
                return trim("{$city}, {$country}", ', ') ?: null;
            }
        } catch (\Throwable) {}

        return null;
    }
}
