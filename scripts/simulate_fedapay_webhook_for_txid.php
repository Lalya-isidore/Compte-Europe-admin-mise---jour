<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\RechargeTransaction;
use Illuminate\Http\Request;

// Usage: php simulate_fedapay_webhook_for_txid.php <tx_identifier> [approved|canceled]
$txParam = $argv[1] ?? null;
$mode = $argv[2] ?? 'canceled';

if (! $txParam) {
    echo "Usage: php simulate_fedapay_webhook_for_txid.php <tx_identifier> [approved|canceled]\n";
    exit(1);
}

// Disable webhook signature verification for this test
config(['services.fedapay.webhook_secret' => null]);

// Try to find by transaction_id first, then by numeric primary key
$transaction = RechargeTransaction::where('transaction_id', $txParam)->first();
if (! $transaction && is_numeric($txParam)) {
    $transaction = RechargeTransaction::find((int) $txParam);
}

if (! $transaction) {
    echo "Transaction not found for identifier: {$txParam}\n";
    exit(2);
}

$txId = $transaction->transaction_id;

$statusName = $mode === 'approved' ? 'transaction.approved' : 'transaction.canceled';

$payloadArray = [
    'name' => $statusName,
    'entity' => [
        'custom_metadata' => [
            'transaction_id' => $txId
        ]
    ],
    'data' => [
        'object' => [
            'custom_metadata' => [
                'transaction_id' => $txId
            ],
            'id' => $transaction->external_transaction_id ?? null
        ],
        'transaction_id' => $txId
    ],
    'transaction_id' => $txId
];

$payload = json_encode($payloadArray);

$server = [
    'CONTENT_TYPE' => 'application/json'
];

$request = Request::create('/recharge/webhook/fedapay', 'POST', [], [], [], $server, $payload);

/** @var \App\Http\Controllers\RechargeController $controller */
$controller = app('App\\Http\\Controllers\\RechargeController');
$response = $controller->fedapayWebhook($request);

echo "Response: ";
if ($response instanceof \Illuminate\Http\Response || $response instanceof \Illuminate\Http\JsonResponse) {
    echo $response->getContent();
} else {
    echo (string) $response;
}

echo "\nUsing TXID: {$txId} (DB id: {$transaction->id})\n";

// Refresh from DB
$transaction->refresh();

echo "Transaction status after webhook: " . $transaction->status . "\n";
if (! empty($transaction->failure_reason)) {
    echo "Failure reason: " . $transaction->failure_reason . "\n";
}

exit(0);
