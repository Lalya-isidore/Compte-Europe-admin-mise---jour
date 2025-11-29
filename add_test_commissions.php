<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "\n========================================\n";
echo "AJOUT DE COMMISSIONS DE TEST\n";
echo "========================================\n\n";

// Récupérer l'utilisateur connecté (le premier avec une affiliation)
$user = DB::table('users')
    ->join('affiliations', 'users.id', '=', 'affiliations.user_id')
    ->select('users.*', 'affiliations.id as affiliation_id')
    ->first();

if (!$user) {
    echo "❌ Aucun utilisateur avec affiliation trouvé.\n";
    echo "Veuillez d'abord activer le programme d'affiliation.\n\n";
    exit(1);
}

echo "Utilisateur trouvé: {$user->nom} {$user->prenom} ({$user->email})\n";
echo "Affiliation ID: {$user->affiliation_id}\n\n";

// Ajouter des commissions de test
echo "Ajout de commissions de test...\n\n";

$commissions = [
    ['montant' => 2000, 'description' => 'Commission test 1'],
    ['montant' => 3000, 'description' => 'Commission test 2'],
    ['montant' => 1500, 'description' => 'Commission test 3'],
    ['montant' => 2500, 'description' => 'Commission test 4'],
];

$total = 0;

foreach ($commissions as $commission) {
    DB::table('commissions')->insert([
        'affiliation_id' => $user->affiliation_id,
        'parraine_user_id' => $user->id,
        'compte_id' => null,
        'action_type' => 'test_commission',
        'montant_base' => $commission['montant'],
        'montant_commission' => $commission['montant'],
        'taux_commission' => 5.00,
        'statut' => 'valide',
        'date_action' => now(),
        'date_validation' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    echo "✓ Commission ajoutée: {$commission['montant']} F CFA - {$commission['description']}\n";
    $total += $commission['montant'];
}

echo "\n========================================\n";
echo "✅ TOTAL DES GAINS: " . number_format($total, 0, ',', ' ') . " F CFA\n";
echo "========================================\n\n";
echo "Rechargez la page d'affiliation pour voir le formulaire de retrait !\n";
echo "URL: http://127.0.0.1:8000/affiliation\n\n";
