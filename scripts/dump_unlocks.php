<?php
// scripts/dump_unlocks.php
// Usage:
// php scripts/dump_unlocks.php           -> lists last 20 unlock codes
// php scripts/dump_unlocks.php compte 93 -> lists last 50 unlock codes for compte_id=93
// php scripts/dump_unlocks.php code 21244243 -> show unlock by code

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\UnlockCode;

$args = $argv;
array_shift($args); // script name

try {
    if (count($args) >= 2 && $args[0] === 'compte') {
        $compteId = intval($args[1]);
        $rows = UnlockCode::where('compte_id', $compteId)->latest()->take(50)->get();
        echo "Unlock codes for compte_id={$compteId}:\n";
        echo $rows->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "\n";
    } elseif (count($args) >= 2 && $args[0] === 'code') {
        $code = $args[1];
        $row = UnlockCode::where('code', $code)->latest()->first();
        echo "Unlock code lookup for code={$code}:\n";
        echo json_encode($row?->toArray() ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "\n";
    } else {
        $rows = UnlockCode::latest()->take(20)->get();
        echo "Latest 20 unlock codes:\n";
        echo $rows->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "\n";
    }
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}

exit(0);
