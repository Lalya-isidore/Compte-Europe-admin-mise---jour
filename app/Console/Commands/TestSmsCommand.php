<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SmsService;

class TestSmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:test {phone=+2290198201610}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester l\'envoi de SMS via le fournisseur configuré (Infobip par défaut)';

    /**
     * Execute the console command.
     */
    public function handle(SmsService $smsService)
    {
        $phone = $this->argument('phone');
        $provider = config('sms.provider', 'infobip');

        $this->info("📱 Test d'envoi de SMS via {$provider}...");
        $this->info("📞 Numéro de destination : {$phone}");

        try {
            if ($provider === 'infobip') {
                $apiKey = config('services.infobip.api_key');
                $baseUrl = config('services.infobip.base_url');
                $sender = config('services.infobip.sender');

                if (empty($apiKey)) {
                    $this->error('❌ Configuration Infobip manquante dans .env');
                    $this->warn('Ajoutez ces variables :');
                    $this->line('INFOBIP_API_KEY=votre_api_key');
                    $this->line('INFOBIP_BASE_URL=https://votre_id.api.infobip.com');
                    $this->line('INFOBIP_SENDER=Movicredo');
                    return 1;
                }

                $this->info('✅ Configuration Infobip trouvée');
                $this->line("   Base URL : {$baseUrl}");
                $this->line("   Sender : {$sender}");
            } else {
                // Vérifier la configuration Twilio
                $accountSid = config('services.twilio.account_sid');
                $authToken = config('services.twilio.auth_token');
                $from = config('services.twilio.phone_number');

                if (empty($accountSid) || empty($authToken) || empty($from)) {
                    $this->error('❌ Configuration Twilio manquante dans .env');
                    return 1;
                }

                $this->info('✅ Configuration Twilio trouvée');
            }

            $message = "🏦 TRANSFERFLUX - Test SMS\n\nCeci est un message de test depuis votre système TRANSFERFLUX via {$provider}.\n\nSi vous recevez ce message, la configuration SMS est opérationnelle ! ✅";

            $response = $smsService->send($phone, $message);

            if ($response['success']) {
                $this->info('✅ Message envoyé avec succès !');
                if (isset($response['message_id'])) {
                    $this->line("   Message ID : {$response['message_id']}");
                }
            } else {
                $this->error('❌ Échec de l\'envoi : ' . ($response['error'] ?? 'Erreur inconnue'));
                return 1;
            }

            $this->info("📧 Vérifiez le numéro : {$phone}");

            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de l\'envoi du SMS :');
            $this->error($e->getMessage());

            return 1;
        }
    }
}
