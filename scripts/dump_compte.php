<?php
// scripts/dump_compte.php
// Usage: php scripts/dump_compte.php 93
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Compte;

$argv2 = $argv;
array_shift($argv2);
if (!isset($argv2[0])) {
    echo "Usage: php scripts/dump_compte.php COMPTE_ID\n";
    exit(1);
}
$id = intval($argv2[0]);
$compte = Compte::find($id);
if (!$compte) {
    echo "Compte not found: {$id}\n";
    exit(1);
}
echo json_encode($compte->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n";
exit(0);
