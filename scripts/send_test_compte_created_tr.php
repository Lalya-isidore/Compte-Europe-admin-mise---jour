<?php
// Usage: from project root run: php scripts/send_test_compte_created_tr.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Mail\CompteCreeMail;
use App\Models\Compte;
use App\Services\SafeMailService;

$to = 'lalyaisidore@gmail.com';

// Build minimal details array expected by the view
$details = [
    'name' => 'Lalya Isidore',
    'account_number' => 'TEST-TR-'.time(),
    'opened_at' => now()->toDateTimeString(),
];

// Create a dummy Compte model instance (not saved to DB)
$compte = new Compte();
$compte->lang = 'tr';
$compte->email = $to;
$compte->name = $details['name'];

// Instantiate the mailable
$mailable = new CompteCreeMail($details, $compte);

echo "Mailer default (config): " . config('mail.default') . PHP_EOL;

if (!SafeMailService::isAvailable()) {
    echo "Warning: SafeMailService reports mailer not configured or missing settings.\n";
    echo "Please ensure SMTP / mailer settings are correct in .env (MAIL_MAILER, MAIL_HOST, MAIL_USERNAME, MAIL_PASSWORD)\n";
}

echo "Sending account opening (CompteCreeMail) in Turkish to: $to\n";
$ok = SafeMailService::send($to, $mailable, 'Test Compte Ouverture', 'tr');

if ($ok) {
    echo "SafeMailService::send returned true — mail send attempted. Check logs and recipient inbox.\n";
} else {
    echo "SafeMailService::send returned false — see logs for details.\n";
}
