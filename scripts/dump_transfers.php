<?php
// scripts/dump_transfers.php
// Usage:
// php scripts/dump_transfers.php           -> lists last 20 transfers
// php scripts/dump_transfers.php compte 93 -> lists last 50 transfers for compte_id=93

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Transfer;

$args = $argv;
array_shift($args);

try {
    if (count($args) >= 2 && $args[0] === 'compte') {
        $compteId = intval($args[1]);
        $rows = Transfer::where('compte_id', $compteId)->latest()->take(50)->get();
        echo "Transfers for compte_id={$compteId}:\n";
        echo $rows->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "\n";
    } else {
        $rows = Transfer::latest()->take(20)->get();
        echo "Latest 20 transfers:\n";
        echo $rows->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "\n";
    }
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}

exit(0);
