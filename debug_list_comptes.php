<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Compte;

$comptes = Compte::orderBy('id','desc')->limit(30)->get(['id','user_id','photo_path','numerocompte']);
foreach ($comptes as $c) {
    echo sprintf("id=%d user_id=%s numerocompte=%s photo_path=%s\n", $c->id, $c->user_id, $c->numerocompte, var_export($c->photo_path,true));
}
