<?php
// Script simple pour vérifier les crédits d'un utilisateur
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VÉRIFICATION CRÉDITS UTILISATEUR ===" . PHP_EOL;

// Remplacez par votre email ou ID utilisateur
$userEmail = ''; // Laissez vide pour voir tous les utilisateurs
$user = App\Models\User::where('email', $userEmail)->first();

if (!$user) {
    echo "Utilisateur non trouvé. Vérifiez l'email." . PHP_EOL;
    echo "Utilisateurs disponibles:" . PHP_EOL;
    $users = App\Models\User::select('id', 'email', 'credit_user')->limit(5)->get();
    foreach ($users as $u) {
        echo "- ID: {$u->id}, Email: {$u->email}, Crédits: {$u->credit_user}" . PHP_EOL;
    }
    exit;
}

echo "Utilisateur: {$user->email}" . PHP_EOL;
echo "Crédits actuels: {$user->credit_user}" . PHP_EOL;
echo "ID utilisateur: {$user->id}" . PHP_EOL;

echo PHP_EOL . "=== DERNIÈRES TRANSACTIONS ===" . PHP_EOL;
$transactions = App\Models\RechargeTransaction::where('user_id', $user->id)
                                            ->orderBy('created_at', 'desc')
                                            ->limit(3)
                                            ->get();

foreach ($transactions as $t) {
    echo "Transaction {$t->id}: {$t->amount}F CFA → {$t->credits_earned} crédits - Statut: {$t->status} - {$t->created_at}" . PHP_EOL;
}

if ($transactions->isEmpty()) {
    echo "Aucune transaction trouvée pour cet utilisateur." . PHP_EOL;
}

echo PHP_EOL . "=== TOUTES LES TRANSACTIONS RÉCENTES ===" . PHP_EOL;
$allTransactions = App\Models\RechargeTransaction::orderBy('created_at', 'desc')->limit(5)->get();
foreach ($allTransactions as $t) {
    echo "Transaction {$t->id} (User {$t->user_id}): {$t->amount}F CFA → {$t->credits_earned} crédits - Statut: {$t->status} - {$t->created_at}" . PHP_EOL;
}
?>