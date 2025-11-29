<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SafeMailService;
use App\Mail\MailErrorAlert;

class TestAdminAlertCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:admin-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester l\'alerte admin en simulant un échec d\'envoi d\'email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test de l\'alerte administrateur...');
        $this->newLine();

        try {
            // Simuler les détails d'une erreur
            $errorDetails = [
                'date' => now()->format('d/m/Y H:i:s'),
                'type' => 'Symfony\Component\Mailer\Exception\TransportException',
                'code' => 550,
            ];

            $failedRecipient = 'client.test@example.com';
            $context = 'Email de confirmation de compte';
            $errorMessage = 'Expected response code "250" but got code "550", with message "550-5.4.5 Daily user sending quota exceeded."';

            // Envoyer l'email d'alerte via SafeMailService pour utiliser la même
            // logique (locale, logs, cooldown) que les autres envois.
            \App\Services\SafeMailService::send(
                'lalyaisidore@gmail.com',
                new MailErrorAlert(
                    $errorDetails,
                    $failedRecipient,
                    $context,
                    $errorMessage
                ),
                'Test admin alert'
            );

            $this->newLine();
            $this->info('✅ Email d\'alerte envoyé avec succès !');
            $this->info('📧 Vérifiez la boîte de réception : lalyaisidore@gmail.com');
            $this->newLine();
            
            $this->line('📋 Détails de l\'alerte envoyée :');
            $this->line('  • Destinataire: lalyaisidore@gmail.com');
            $this->line('  • Type: Simulation d\'erreur de limite quotidienne');
            $this->line('  • Message: Limite quotidienne de 550 emails dépassée');
            
            $this->newLine();
            $this->comment('💡 Cette alerte sera envoyée automatiquement lorsque:');
            $this->comment('   - La limite Gmail de 500 emails/jour est atteinte');
            $this->comment('   - Le serveur SMTP est inaccessible');
            $this->comment('   - L\'authentification échoue');
            $this->comment('   - Tout autre problème d\'envoi d\'email survient');
            
            $this->newLine();
            $this->comment('⏱️  Cooldown: Une seule alerte par heure maximum pour éviter le spam');

        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de l\'envoi de l\'alerte : ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
