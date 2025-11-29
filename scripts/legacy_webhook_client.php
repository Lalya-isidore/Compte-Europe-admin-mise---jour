<?php
// Example client script to call the Laravel webhook from legacy PHP project
// Usage: php scripts/legacy_webhook_client.php

$payload = [
    'compte_id' => 101,
    'code' => null,
    'amount' => 10000,
    'numerocompte' => '1234567890',
    'name_servieur' => 'SERVEUR X',
    'beneficiary_name' => 'DESTINATAIRE',
    'reason' => 'virement via legacy',
    'timestamp' => time(),
];

$secret = 'REPLACE_WITH_LEGACY_WEBHOOK_SECRET';
$body = json_encode($payload);
$signature = hash_hmac('sha256', $body, $secret);

$ch = curl_init('http://localhost/api/legacy/webhook/virement');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Signature: ' . $signature,
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP {$httpCode}\n";
echo $response . PHP_EOL;
