<?php
// scripts/send_refund_test.php
// Usage: php scripts/send_refund_test.php recipient@example.com en

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Compte;
use App\Models\Transfer;
use App\Mail\RemborsementMail;
use App\Mail\CompteBloqueMail;
use App\Services\SafeMailService;

$recipient = $argv[1] ?? 'lalyaisidore@gmail.com';
$locale = $argv[2] ?? 'en';

// Try to load an existing compte; otherwise create a temporary one in-memory
$compte = Compte::first();
if (! $compte) {
    $compte = new Compte([
        'nom' => 'Test',
        'prenom' => 'User',
        'email' => $recipient,
        'devise' => 'EUR',
        'account_balance2' => 12.34,
        'lang' => $locale,
    ]);
}


$transfer = new Transfer();
$transfer->created_at = now();
$transfer->beneficiary_name = 'John Doe';
$transfer->reason = 'Test refund';

$mailable = new CompteBloqueMail($compte);

$ok = SafeMailService::send($recipient, $mailable, 'Account blocked - Test', $locale);

echo $ok ? "Mail envoyé avec succès\n" : "Échec de l'envoi du mail\n";
