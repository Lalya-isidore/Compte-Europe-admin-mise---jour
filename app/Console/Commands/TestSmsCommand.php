<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TwilioService;

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
    protected $description = 'Tester l\'envoi de SMS/WhatsApp via Twilio';

    /**
     * Execute the console command.
     */
    public function handle(TwilioService $twilioService)
    {
        $phone = $this->argument('phone');
        
        $this->info("📱 Test d'envoi de SMS/WhatsApp...");
        $this->info("📞 Numéro de destination : {$phone}");
        
        try {
            // Vérifier la configuration Twilio
            $accountSid = config('services.twilio.account_sid');
            $authToken = config('services.twilio.auth_token');
            $from = config('services.twilio.whatsapp_from');
            
            if (empty($accountSid) || empty($authToken) || empty($from)) {
                $this->error('❌ Configuration Twilio manquante dans .env');
                $this->warn('Ajoutez ces variables :');
                $this->line('TWILIO_ACCOUNT_SID=votre_account_sid');
                $this->line('TWILIO_AUTH_TOKEN=votre_auth_token');
                $this->line('TWILIO_WHATSAPP_FROM=whatsapp:+14155238886');
                return 1;
            }
            
            $this->info('✅ Configuration Twilio trouvée');
            $this->line("   Account SID : " . substr($accountSid, 0, 10) . "...");
            $this->line("   From : {$from}");
            
            $message = "🏦 TRANSFERFLUX - Test SMS\n\nCeci est un message de test depuis votre système TRANSFERFLUX.\n\nSi vous recevez ce message, la configuration SMS est opérationnelle ! ✅";
            
            $twilioService->sendWhatsAppMessage($phone, $message);
            
            $this->info('✅ Message envoyé avec succès !');
            $this->info("📧 Vérifiez le numéro : {$phone}");
            $this->line('Note: Vérifiez aussi les logs pour plus de détails');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de l\'envoi du SMS :');
            $this->error($e->getMessage());
            
            return 1;
        }
    }
}
