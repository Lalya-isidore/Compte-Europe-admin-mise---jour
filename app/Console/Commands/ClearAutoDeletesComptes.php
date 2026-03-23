<?php

namespace App\Console\Commands;

use App\Models\Compte;
use Illuminate\Console\Command;

class ClearAutoDeletesComptes extends Command
{
    protected $signature = 'comptes:clear-auto-deletes';
    protected $description = 'Enlève la date `auto_deletes_at` pour tous les comptes auto-créés afin d\'empêcher leur suppression automatique.';

    public function handle()
    {
        $count = Compte::where('is_auto_created', true)
            ->whereNotNull('auto_deletes_at')
            ->update(['auto_deletes_at' => null]);

        $this->info("Mis à jour de {$count} compte(s) auto-créés : `auto_deletes_at` mis à NULL.");
        return 0;
    }
}
