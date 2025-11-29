<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->handle(new Symfony\Component\Console\Input\ArgvInput, new Symfony\Component\Console\Output\BufferedOutput);

use App\Models\Transfer;

$rows = Transfer::whereNotNull('compte_id')->take(10)->get();
if ($rows->isEmpty()) {
    echo "No transfers with compte_id found.\n";
    exit(0);
}

foreach ($rows as $r) {
    echo "id={$r->id} numerocompte={$r->numerocompte} user_id={$r->user_id} compte_id={$r->compte_id} name_servieur={$r->name_servieur} beneficiary_name={$r->beneficiary_name}\n";
}

?>