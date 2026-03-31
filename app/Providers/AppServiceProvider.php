<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Compte;
use App\Observers\CompteObserver;
use App\Models\Transfer;
use App\Observers\TransferObserver;
use App\Services\RegionManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('region', RegionManager::class);
        $this->app->singleton(RegionManager::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enregistrer l'observer pour les comptes
        Compte::observe(CompteObserver::class);
    // Enregistrer l'observer pour les virements/transfers afin de marquer les unlock codes
    Transfer::observe(TransferObserver::class);
        
        // Helper pour formater les dates des transactions dans les vues
        // Vérifier l'existence en utilisant le nom qualifié (namespace) pour éviter
        // la redéclaration si le fichier est inclus/chargé plusieurs fois.
        if (! function_exists(__NAMESPACE__ . '\\formatTransactionDate')) {
            function formatTransactionDate($date)
            {
                // Accepte null, string ou Carbon
                if (!$date) {
                    return '';
                }

                return \Carbon\Carbon::parse($date)
                    ->timezone(config('app.timezone'))
                    ->format('d/m/Y H:i');
            }
        }
    }
}
