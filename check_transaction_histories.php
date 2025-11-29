<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Structure de transaction_histories:\n";
$columns = DB::select('DESCRIBE transaction_histories');
foreach($columns as $col) {
    echo "  - {$col->Field} ({$col->Type})\n";
}
