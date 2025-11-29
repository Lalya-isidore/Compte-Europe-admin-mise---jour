<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Compte;
use App\Models\RechargeTransaction;
use Illuminate\Http\Request;

$user = User::first();
if (! $user) {
    echo "No users found in DB\n";
    exit(1);
}

$compte = Compte::where('user_id', $user->id)->first();
if (! $compte) {
    echo "No compte found for user {$user->id}\n";
    exit(1);
}

$txId = 'RCTEST'.time();
$transaction = RechargeTransaction::create([
    'user_id' => $user->id,
    'compte_id' => $compte->id,
    'transaction_id' => $txId,
    'amount' => 5000,
    'credits_earned' => 5000,
    'payment_method' => 'fedapay',
    'status' => 'pending'
]);

$payload = json_encode([
    'name' => 'transaction.canceled',
    'entity' => [
        'custom_metadata' => [
            'transaction_id' => $txId
        ]
    ]
]);

$secret = config('services.fedapay.webhook_secret');
$sig = $secret ? 'sha256=' . hash_hmac('sha256', $payload, $secret) : null;
$server = [];
if ($sig) {
    $server['HTTP_X_FEDAPAY_SIGNATURE'] = $sig;
}

$request = Request::create('/recharge/webhook/fedapay', 'POST', [], [], [], $server, $payload);

/** @var \App\Http\Controllers\RechargeController $controller */
$controller = app('App\\Http\\Controllers\\RechargeController');
$response = $controller->fedapayWebhook($request);

echo "Response: ";
if ($response instanceof \Illuminate\Http\Response || $response instanceof \Illuminate\Http\JsonResponse) {
    echo $response->getContent();
} else {
    // could be string
    echo (string) $response;
}

echo "\nCreated TXID: {$txId}\n";

// Show updated transaction status
$tx = RechargeTransaction::where('transaction_id', $txId)->first();
if ($tx) {
    echo "Transaction status after webhook: " . $tx->status . "\n";
    if ($tx->failure_reason) echo "Failure reason: " . $tx->failure_reason . "\n";
}
