<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester la configuration email TRANSFERFLUX';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Envoi d\'un email de test...');
        
        try {
            Mail::raw('Test TRANSFERFLUX - Email configuré avec succès ! ✅', function($message) {
                $message->to('fluxbank37@gmail.com')
                        ->subject('Test Configuration Email - TRANSFERFLUX');
            });
            
            $this->info('✅ Email de test envoyé avec succès !');
            $this->info('📧 Vérifiez votre boîte de réception : fluxbank37@gmail.com');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de l\'envoi de l\'email :');
            $this->error($e->getMessage());
            
            return 1;
        }
    }
}
