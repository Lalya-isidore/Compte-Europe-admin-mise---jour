<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Register command classes here if you want auto discovery
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Exécuter toutes les minutes pour précision (déclenchera les jobs pour comptes expirés)
        // Désactivé : suppression automatique des comptes auto-créés désactivée (suppression manuelle)
        // $schedule->command('comptes:cleanup-auto')->everyMinute();
        
        // Nettoyer les conversations de support de plus de 7 jours (tous les jours à 3h du matin)
        $schedule->command('support:clean-old --force')
                 ->dailyAt('03:00')
                 ->withoutOverlapping()
                 ->onSuccess(function () {
                     \Log::info('Nettoyage automatique des tickets de support exécuté avec succès');
                 })
                 ->onFailure(function () {
                     \Log::error('Échec du nettoyage automatique des tickets de support');
                 });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
