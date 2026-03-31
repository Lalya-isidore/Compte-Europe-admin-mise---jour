<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class RegionManager
{
    /**
     * Resolve the current region based on:
     * 1. Authenticated user's region column
     * 2. Request domain
     * 3. Session
     * 4. Default to 'europe'
     */
    public function current(): string
    {
        if (Auth::check() && Auth::user()->region) {
            return Auth::user()->region;
        }

        $host = request()->getHost();
        $afriqueDomain = config('regions.afrique.domain');
        if ($afriqueDomain && str_contains($host, $afriqueDomain)) {
            return 'afrique';
        }

        if (session('detected_region')) {
            return session('detected_region');
        }

        return 'europe';
    }

    public function config(string $key = null, $default = null)
    {
        $region = $this->current();
        if ($key === null) {
            return config("regions.{$region}");
        }
        return config("regions.{$region}.{$key}", $default);
    }

    public function isEurope(): bool
    {
        return $this->current() === 'europe';
    }

    public function isAfrique(): bool
    {
        return $this->current() === 'afrique';
    }

    public function hasFeature(string $feature): bool
    {
        return (bool) $this->config("features.{$feature}", false);
    }

    public function appName(): string
    {
        return $this->config('app_name', config('app.name'));
    }

    public function webhookSecret(): string
    {
        return $this->config('fedapay_webhook_secret', '');
    }
}
