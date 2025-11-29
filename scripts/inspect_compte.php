<?php
// Usage: php scripts/inspect_compte.php <compte_id>
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Compte;
use App\Models\Transfer;
use App\Models\TransactionHistory;
use App\Models\UnlockCode;

$compteId = isset($argv[1]) ? (int)$argv[1] : null;
if (! $compteId) {
    echo "Usage: php scripts/inspect_compte.php <compte_id>\n";
    exit(1);
}

$compte = Compte::find($compteId);
if (! $compte) {
    echo "Compte {$compteId} non trouvé\n";
    exit(0);
}

echo "Compte: id={$compte->id} user_id={$compte->user_id} balance={$compte->account_balance} code_virement={$compte->code_virement}\n";

$transfers = Transfer::where('compte_id', $compteId)->orderBy('created_at','desc')->get();
$transfersAlt = Transfer::where('user_id', $compte->user_id)->orderBy('created_at','desc')->limit(10)->get();

echo "\nTransfers (compte_id={$compteId}) count=".count($transfers)."\n";
foreach ($transfers as $t) {
    echo "id={$t->id} status={$t->status} solidvire={$t->solidvire} numerocompte={$t->numerocompte} transfer_created_at={$t->created_at}\n";
}

echo "\nRecent Transfers for user_id={$compte->user_id} (limit 10): count=".count($transfersAlt)."\n";
foreach ($transfersAlt as $t) {
    echo "id={$t->id} compte_id={$t->compte_id} status={$t->status} solidvire={$t->solidvire} created_at={$t->created_at}\n";
}

$hist = TransactionHistory::where('compte_id', $compteId)->orderBy('created_at','desc')->limit(20)->get();

echo "\nTransactionHistory (compte_id={$compteId}) count=".count($hist)."\n";
foreach ($hist as $h) {
    echo "id={$h->id} type={$h->transaction_type} amount={$h->amount} created_at={$h->created_at}\n";
}

$unlock = UnlockCode::where('compte_id', $compteId)->orderBy('created_at','desc')->get();
echo "\nUnlockCodes (compte_id={$compteId}) count=".count($unlock)."\n";
foreach ($unlock as $u) {
    echo "id={$u->id} code={$u->code} used_at=".($u->used_at?$u->used_at->toDateTimeString():'NULL')." transfer_id={$u->transfer_id}\n";
}
