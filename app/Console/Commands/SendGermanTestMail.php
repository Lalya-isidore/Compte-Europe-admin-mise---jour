<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\TestGermanMail;
use App\Services\SafeMailService;

class SendGermanTestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:german-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie un mail d\'essai en allemand à lalyaisidore@gmail.com';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Envoi du mail de test en allemand vers lalyaisidore@gmail.com ...');

        $mailable = new TestGermanMail();

        $sent = SafeMailService::send('lalyaisidore@gmail.com', $mailable, 'Test German Email', 'de');

        if ($sent) {
            $this->info('✅ Mail envoyé (ou bufferé) avec succès.');
            return 0;
        }

        $this->error('❌ Échec lors de l\'envoi du mail de test. Consultez les logs pour plus de détails.');
        return 1;
    }
}
