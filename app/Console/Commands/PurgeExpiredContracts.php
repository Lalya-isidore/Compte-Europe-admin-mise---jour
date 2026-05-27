<?php

namespace App\Console\Commands;

use App\Models\ContractHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class PurgeExpiredContracts extends Command
{
    protected $signature = 'contracts:purge-expired';
    protected $description = 'Supprime les contrats expirés (> 30 jours) du stockage et de la base de données';

    public function handle(): int
    {
        $expired = ContractHistory::where('expires_at', '<=', now())->get();
        $count = 0;

        foreach ($expired as $record) {
            $path = $record->storagePath();
            if (Storage::disk('local')->exists($path)) {
                Storage::disk('local')->delete($path);
            }
            $record->delete();
            $count++;
        }

        $this->info("Purgé : {$count} contrat(s) expiré(s).");
        return self::SUCCESS;
    }
}
