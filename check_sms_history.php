<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Historique SMS ===\n\n";

$smsHistory = DB::table('sms_history')->orderBy('id', 'desc')->get();

echo "Total: " . $smsHistory->count() . " SMS\n\n";

foreach ($smsHistory as $sms) {
    echo "SMS #{$sms->id}\n";
    echo "  Statut: {$sms->status}\n";
    echo "  Crédits utilisés: {$sms->credits_used}\n";
    echo "  Date: {$sms->created_at}\n";
    echo "  Destinataire: {$sms->destinataire}\n";
    echo "  Message ID: {$sms->message_id}\n";
    if ($sms->error_message) {
        echo "  Erreur: {$sms->error_message}\n";
    }
    echo "\n";
}

// Vérifier les crédits de l'utilisateur 60
$user = DB::table('users')->where('id', 60)->first();
if ($user) {
    echo "=== Utilisateur #60 ===\n";
    echo "Crédits actuels: {$user->credit_user}\n";
}
