<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->handle(new Symfony\Component\Console\Input\ArgvInput, new Symfony\Component\Console\Output\BufferedOutput);

use App\Models\Compte;
use App\Models\Transfer;

$id = $argv[1] ?? 90;
$compte = Compte::find($id);
if (! $compte) {
    echo "Compte {$id} not found\n";
    exit(0);
}

echo "id: {$compte->id}\n";
echo "numerocompte: {$compte->numerocompte}\n";
echo "user_id: {$compte->user_id}\n";
echo "is_auto_created: " . ($compte->is_auto_created ? '1' : '0') . "\n";
echo "auto_deletes_at: " . ($compte->auto_deletes_at ? $compte->auto_deletes_at->toDateTimeString() : 'NULL') . "\n";

$txCount = 0;
try {
    $txCount = $compte->transactionHistories()->count();
} catch (Throwable $e) {
    echo "transactionHistories count failed: " . $e->getMessage() . "\n";
}

echo "transactionHistories count: {$txCount}\n";

// Count transfers by numerocompte and user_id
try {
    $byNum = Transfer::where('numerocompte', $compte->numerocompte)->count();
    $byUser = $compte->user_id ? Transfer::where('user_id', $compte->user_id)->count() : 0;
    echo "transfers by numerocompte: {$byNum}\n";
    echo "transfers by user_id: {$byUser}\n";

    $sample = Transfer::where('numerocompte', $compte->numerocompte)->orWhere('user_id', $compte->user_id)->take(10)->get();
    echo "sample transfers (up to 10):\n";
    foreach ($sample as $t) {
        echo json_encode($t->toArray()) . "\n";
    }
} catch (Throwable $e) {
    echo "transfers query failed: " . $e->getMessage() . "\n";
}

?>