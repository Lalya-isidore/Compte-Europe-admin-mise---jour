<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$tables = DB::select('SHOW TABLES');

echo "Tables contenant 'histor':\n";
foreach($tables as $table) {
    $tableName = array_values((array)$table)[0];
    if(stripos($tableName, 'histor') !== false) {
        echo "  - $tableName\n";
    }
}
