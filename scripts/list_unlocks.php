<?php
// Usage: php scripts/list_unlocks.php <compte_id>
// Lists unlock codes for a compte

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\UnlockCode;

$compteId = isset($argv[1]) ? (int)$argv[1] : null;
if (! $compteId) {
    echo "Usage: php scripts/list_unlocks.php <compte_id>\n";
    exit(1);
}

$rows = UnlockCode::where('compte_id', $compteId)->orderBy('created_at', 'desc')->get();
if ($rows->isEmpty()) {
    echo "Aucun UnlockCode trouvé pour compte_id={$compteId}\n";
    exit(0);
}

foreach ($rows as $r) {
    echo sprintf("id=%d code=%s used_at=%s transfer_id=%s created_at=%s\n", $r->id, $r->code, $r->used_at ? $r->used_at->toDateTimeString() : 'NULL', $r->transfer_id ?? 'NULL', $r->created_at->toDateTimeString());
}
