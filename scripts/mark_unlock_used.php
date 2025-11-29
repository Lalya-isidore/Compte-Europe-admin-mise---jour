<?php
// Usage: php scripts/mark_unlock_used.php <compte_id>
// This script bootstraps the Laravel app and marks the most recent unused UnlockCode for the given compte_id as used.

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\UnlockCode;

$compteId = isset($argv[1]) ? (int)$argv[1] : null;
if (! $compteId) {
    echo "Usage: php scripts/mark_unlock_used.php <compte_id>\n";
    exit(1);
}

try {
    $unlock = UnlockCode::where('compte_id', $compteId)
        ->whereNull('used_at')
        ->latest()
        ->first();

    if (! $unlock) {
        echo "Aucun UnlockCode non utilisé trouvé pour compte_id={$compteId}\n";
        exit(0);
    }

    $unlock->markAsUsed();
    echo "Marqué utilisé: unlock_id={$unlock->id}, code={$unlock->code}, compte_id={$unlock->compte_id}\n";
    exit(0);
} catch (\Throwable $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
    exit(2);
}
