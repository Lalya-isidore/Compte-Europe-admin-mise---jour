<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\SmsHistory;
use Illuminate\Support\Facades\DB;

echo "=== Test de simulation de webhook SMS ===\n\n";

// Récupérer le dernier SMS envoyé
$sms = SmsHistory::latest()->first();

if (!$sms) {
    echo "❌ Aucun SMS dans l'historique. Envoyez d'abord un SMS via l'interface.\n";
    exit(1);
}

echo "SMS trouvé :\n";
echo "  ID: {$sms->id}\n";
echo "  Message ID: {$sms->message_id}\n";
echo "  Destinataire: {$sms->destinataire}\n";
echo "  Statut actuel: {$sms->status}\n";
echo "  Crédits utilisés: {$sms->credits_used}\n\n";

// Récupérer les crédits avant
$user = DB::table('users')->where('id', $sms->user_id)->first();
$creditsBefore = $user->credit_user;
echo "Crédits utilisateur AVANT: {$creditsBefore}\n\n";

// Simuler un webhook de rejet
echo "=== Simulation d'un webhook Twilio (SMS rejeté) ===\n\n";

$webhookData = [
    'MessageSid' => $sms->message_id,
    'MessageStatus' => 'undelivered',
    'ErrorCode' => '30006',
    'ErrorMessage' => 'Landline or unreachable carrier'
];

echo "Envoi de la requête webhook...\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/sms/webhook/status');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($webhookData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'User-Agent: TwilioProxy/1.1'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Réponse HTTP: {$httpCode}\n";
echo "Réponse: {$response}\n\n";

// Vérifier les changements
$sms->refresh();
$user = DB::table('users')->where('id', $sms->user_id)->first();
$creditsAfter = $user->credit_user;

echo "=== Résultat ===\n\n";
echo "Statut SMS APRÈS: {$sms->status}\n";
echo "Crédits utilisés APRÈS: {$sms->credits_used}\n";
echo "Crédits utilisateur APRÈS: {$creditsAfter}\n";
echo "Différence de crédits: " . ($creditsAfter - $creditsBefore) . "\n\n";

if ($sms->status === 'Rejeté' && $creditsAfter > $creditsBefore) {
    echo "✅ Test réussi ! Le SMS a été marqué comme rejeté et les crédits ont été remboursés.\n";
} elseif ($sms->status === 'Rejeté') {
    echo "⚠️  Le SMS a été marqué comme rejeté mais les crédits n'ont pas été remboursés.\n";
} else {
    echo "❌ Test échoué. Le statut n'a pas changé.\n";
}

echo "\nVérifiez les logs dans storage/logs/laravel.log pour plus de détails.\n";
