<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

use App\Jobs\DeleteAutoCreatedCompte;
use App\Models\Compte;

$id = $argv[1] ?? null;
if (! $id) {
    echo "Usage: php debug_run_job.php <compte_id>\n";
    exit(1);
}

$compte = Compte::find($id);
if (! $compte) {
    echo "Compte $id not found\n";
    exit(0);
}

echo "Before job: exists? " . (Compte::find($id) ? 'yes' : 'no') . "\n";
$job = new DeleteAutoCreatedCompte($id);
$job->handle();

echo "After job: exists? " . (Compte::find($id) ? 'yes' : 'no') . "\n";

?>