<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->handle(new Symfony\Component\Console\Input\ArgvInput, new Symfony\Component\Console\Output\BufferedOutput);

use App\Models\Compte;

$compte = Compte::find(88);
if (! $compte) {
    echo "Compte 88 not found\n";
    exit(0);
}

echo "id: {$compte->id}\n";
echo "is_auto_created: " . ($compte->is_auto_created ? '1' : '0') . "\n";
echo "auto_deletes_at: " . ($compte->auto_deletes_at ? $compte->auto_deletes_at->toDateTimeString() : 'NULL') . "\n";
echo "transactionHistories: " . $compte->transactionHistories()->count() . "\n";
echo "transfers: " . $compte->transfers()->count() . "\n";

?>