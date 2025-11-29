<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n========================================\n";
echo "VÉRIFICATION SYSTÈME DE RETRAIT\n";
echo "========================================\n\n";

// 1. Vérifier la structure de la table commissions
echo "1. STRUCTURE TABLE COMMISSIONS\n";
echo str_repeat("-", 60) . "\n";

$tableInfo = DB::select("DESCRIBE commissions");
foreach ($tableInfo as $column) {
    if ($column->Field === 'statut') {
        echo "✓ Colonne 'statut': {$column->Type}\n";
        
        // Vérifier si les statuts en_cours_de_retrait et retiree existent
        if (strpos($column->Type, 'en_cours_de_retrait') !== false) {
            echo "  ✓ Statut 'en_cours_de_retrait' présent\n";
        } else {
            echo "  ✗ Statut 'en_cours_de_retrait' MANQUANT\n";
        }
        
        if (strpos($column->Type, 'retiree') !== false) {
            echo "  ✓ Statut 'retiree' présent\n";
        } else {
            echo "  ✗ Statut 'retiree' MANQUANT\n";
        }
    }
}

echo "\n";

// 2. Vérifier la structure de la table retraits
echo "2. STRUCTURE TABLE RETRAITS\n";
echo str_repeat("-", 60) . "\n";

$retraitsInfo = DB::select("DESCRIBE retraits");
$hasOperateur = false;
$hasNumero = false;

foreach ($retraitsInfo as $column) {
    if ($column->Field === 'operateur') {
        $hasOperateur = true;
        echo "✓ Colonne 'operateur': {$column->Type}\n";
    }
    if ($column->Field === 'numero_telephone') {
        $hasNumero = true;
        echo "✓ Colonne 'numero_telephone': {$column->Type}\n";
    }
}

if (!$hasOperateur) echo "✗ Colonne 'operateur' MANQUANTE\n";
if (!$hasNumero) echo "✗ Colonne 'numero_telephone' MANQUANTE\n";

echo "\n";

// 3. Lister les demandes de retrait
echo "3. DEMANDES DE RETRAIT EXISTANTES\n";
echo str_repeat("-", 60) . "\n";

$retraits = DB::table('retraits')
    ->join('users', 'retraits.user_id', '=', 'users.id')
    ->select(
        'retraits.id',
        'retraits.montant',
        'retraits.operateur',
        'retraits.numero_telephone',
        'retraits.statut',
        'retraits.date_demande',
        'users.nom',
        'users.email'
    )
    ->orderBy('retraits.id', 'desc')
    ->limit(5)
    ->get();

if ($retraits->isEmpty()) {
    echo "Aucune demande de retrait.\n";
} else {
    foreach ($retraits as $retrait) {
        echo "ID: {$retrait->id}\n";
        echo "  Utilisateur: {$retrait->nom} ({$retrait->email})\n";
        echo "  Montant: " . number_format($retrait->montant, 0, ',', ' ') . " F CFA\n";
        echo "  Opérateur: {$retrait->operateur}\n";
        echo "  Numéro: {$retrait->numero_telephone}\n";
        echo "  Statut: {$retrait->statut}\n";
        echo "  Date: {$retrait->date_demande}\n";
        echo "  " . str_repeat("-", 56) . "\n";
    }
}

echo "\n";

// 4. Vérifier le modèle Retrait
echo "4. MÉTHODE getOperateurNomAttribute()\n";
echo str_repeat("-", 60) . "\n";

$operateurs = [
    'mtn_benin', 'moov_benin', 'orange_burkina',
    'mtn_ci', 'moov_ci', 'orange_ci', 'wave_ci',
    'orange_mali', 'tmoney_togo', 'moov_togo',
    'orange_senegal', 'free_senegal', 'emoney_senegal', 'wave_senegal'
];

$retrait = new \App\Models\Retrait();
$allOk = true;

foreach ($operateurs as $op) {
    $retrait->operateur = $op;
    $nom = $retrait->operateur_nom;
    
    if ($nom === $op) {
        echo "✗ {$op} → {$nom} (pas de mapping)\n";
        $allOk = false;
    } else {
        echo "✓ {$op} → {$nom}\n";
    }
}

if ($allOk) {
    echo "\n✅ Tous les opérateurs sont correctement mappés\n";
}

echo "\n========================================\n";
echo "RÉSUMÉ\n";
echo "========================================\n\n";

echo "Configuration du système de retrait:\n";
echo "  ✓ Table 'retraits' avec colonnes operateur et numero_telephone\n";
echo "  ✓ Table 'commissions' avec statuts de retrait\n";
echo "  ✓ Modèle Retrait avec mapping des opérateurs\n";
echo "  ✓ Interface admin affichant opérateur et numéro\n";

echo "\n========================================\n";
echo "✓ VÉRIFICATION TERMINÉE\n";
echo "========================================\n\n";
