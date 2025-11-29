<?php

namespace App\Console\Commands;

use App\Jobs\DeleteAutoCreatedCompte;
use App\Models\Compte;
use Illuminate\Console\Command;

class CleanupAutoCreatedComptes extends Command
{
    protected $signature = 'comptes:cleanup-auto';
    protected $description = 'Supprime les comptes auto-crées dont la date de suppression est passée';

    public function handle()
    {
        $comptes = Compte::whereNotNull('auto_deletes_at')
            ->where('auto_deletes_at', '<=', now())
            ->where('is_auto_created', true)
            ->get();

        $count = $comptes->count();
        
        if ($count === 0) {
            $this->info('Aucun compte à supprimer.');
            return 0;
        }

        $this->info("Suppression de {$count} compte(s) expiré(s)...");

        foreach ($comptes as $compte) {
            DeleteAutoCreatedCompte::dispatch($compte->id);
        }

        $this->info('Commande exécutée avec succès.');
        return 0;
    }
}
