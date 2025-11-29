<?php
// Usage: from project root run: php scripts/send_test_remboursement.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Mail\RemborsementMail;
use App\Models\Compte;
use App\Models\Transfer;
use App\Services\SafeMailService;

$to = 'lalyaisidore@gmail.com';

$argLocale = $argv[1] ?? 'de';

$details = [
    'title' => 'Echec de Transfert. Remboursement du Solde',
    'body' => 'Test: Ceci est un e-mail de test de remboursement envoyé depuis l environnement de développement.',
];

// Créer une instance de Compte non persistée
$compte = new Compte();
$compte->lang = $argLocale; // locale from CLI (de/en)
$compte->email = $to;
$compte->nom = 'Lalya';
$compte->prenom = 'Isidore';
$compte->devise = '€';
$compte->account_balance = 5000;

// Créer une instance de Transfer minimale
$transfer = new Transfer();
$transfer->solidvire = 5000;
$transfer->name_servieur = 'TEST-SERVICE';
$transfer->id = time();

$mailable = new RemborsementMail($details, $compte, $transfer);

echo "SafeMailService availability: " . (SafeMailService::isAvailable() ? "YES" : "NO") . PHP_EOL;

echo "Envoi d'un email de remboursement de test à: $to (locale={$argLocale})\n";
$ok = SafeMailService::send($to, $mailable, 'Test Remboursement', $argLocale);

if ($ok) {
    echo "SafeMailService::send returned true — mail attempted. Check logs/inbox.\n";
} else {
    echo "SafeMailService::send returned false — check storage/logs/laravel.log for details.\n";
}

return 0;
