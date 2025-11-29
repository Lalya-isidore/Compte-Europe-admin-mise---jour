<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SafeMailService;
use App\Mail\CompteCreeMail;
use App\Models\Compte;

class SendCompteCreatedTestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:compte-test {email} {locale?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test "ouverture de compte" email using SafeMailService';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $locale = $this->argument('locale') ?? 'fr';

        $details = [
            'title' => 'Test ouverture de compte',
            'message' => 'Ceci est un e-mail de test pour l\'ouverture de compte.'
        ];

        // Create a lightweight Compte instance (not persisted) for the mailable
        $compte = new Compte([
            'nom' => 'Test',
            'prenom' => 'Utilisateur',
            'email' => $email,
            'numerocompte' => Compte::generateAccountNumber(),
            'devise' => 'EUR',
            'lang' => $locale,
        ]);

        $mailable = new CompteCreeMail($details, $compte);

        $this->info("Sending test ouverture de compte mail to {$email} (locale: {$locale})...");

        $ok = SafeMailService::send($email, $mailable, 'Test: CompteCreeMail', $locale);

        if ($ok) {
            $this->info('Mail envoyé avec succès.');
            return 0;
        }

        $this->error('Échec lors de l\'envoi du mail de test. Vérifiez les logs et la configuration MAIL.');
        return 1;
    }
}
