<?php

namespace App\Console\Commands;

use App\Jobs\DeleteAutoCreatedCompte;
use App\Models\Compte;
use App\Models\User;
use Illuminate\Console\Command;

class TestAutoDeleteCompte extends Command
{
    protected $signature = 'test:autodelete';
    protected $description = 'Crée un compte auto-créé avec auto_deletes_at passé et teste le job de suppression';

    public function handle()
    {
        $user = User::first();
        if (! $user) {
            $this->error('Aucun utilisateur existant trouvé.');
            return 1;
        }

        $compte = Compte::create([
            'user_id' => $user->id,
            'nom' => 'TestAuto',
            'prenom' => 'Delete',
            'email' => 'test.autodelete@example.com',
            'phone_number' => '000',
            'account_balance' => 0,
            'account_balance2' => 0,
            'devise' => '€',
            'account_status' => 'Activé',
            'account_type' => 'Standard',
            'country' => 'Test',
            'address' => 'Test',
            'password' => 'pass',
            'numerocompte' => Compte::generateAccountNumber(),
            'card_number' => '0000',
            'cvv' => '000',
            'code_virement' => '000000',
            'alert_email' => 0,
            'alert_sms' => 0,
            'lang' => 'fr',
            'transfer_supported' => 'Non',
            'start_percentage' => 0,
            'end_percentage' => 1,
            'failure_message' => '',
            'photo_path' => null,
            'is_auto_created' => true,
            // make deletion time in the past so job will delete immediately
            'auto_deletes_at' => now()->subMinutes(5),
        ]);

        $this->info("Compte de test créé (id={$compte->id}). Dispatch du job DeleteAutoCreatedCompte...");

        DeleteAutoCreatedCompte::dispatch($compte->id);

        $this->info('Job dispatché (avec QUEUE_CONNECTION=sync il devrait s’exécuter immédiatement).');

        $exists = Compte::find($compte->id) ? 'oui' : 'non';
        $this->info("Le compte existe encore après job ? : {$exists}");

        return 0;
    }
}
