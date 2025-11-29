<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n========================================\n";
echo "TEST DU SYSTÈME DE RETRAIT - AFFILIATION\n";
echo "========================================\n\n";

// 1. Vérifier la structure de la table retraits
echo "1. VÉRIFICATION DE LA TABLE RETRAITS\n";
echo "-------------------------------------\n";

try {
    $tableInfo = DB::select("DESCRIBE retraits");
    echo "✓ Table 'retraits' existe\n\n";
    
    echo "Structure de la table:\n";
    foreach ($tableInfo as $column) {
        if ($column->Field === 'operateur' || $column->Field === 'numero_telephone') {
            echo "  • {$column->Field}: {$column->Type}\n";
        }
    }
    echo "\n";
} catch (Exception $e) {
    echo "✗ Erreur: " . $e->getMessage() . "\n\n";
    exit(1);
}

// 2. Vérifier les retraits existants
echo "2. LISTE DES RETRAITS EXISTANTS\n";
echo "--------------------------------\n";

$retraits = DB::table('retraits')
    ->join('users', 'retraits.user_id', '=', 'users.id')
    ->select(
        'retraits.*',
        'users.nom',
        'users.prenom',
        'users.email'
    )
    ->orderBy('retraits.created_at', 'desc')
    ->limit(10)
    ->get();

if ($retraits->isEmpty()) {
    echo "Aucun retrait trouvé dans la base de données.\n\n";
} else {
    echo "Total des retraits: " . $retraits->count() . "\n\n";
    
    foreach ($retraits as $retrait) {
        echo "ID: {$retrait->id}\n";
        echo "  Utilisateur: {$retrait->nom} {$retrait->prenom} ({$retrait->email})\n";
        echo "  Montant: " . number_format($retrait->montant, 0, ',', ' ') . " F CFA\n";
        echo "  Opérateur: {$retrait->operateur}\n";
        echo "  Numéro: {$retrait->numero_telephone}\n";
        echo "  Statut: {$retrait->statut}\n";
        echo "  Date demande: {$retrait->date_demande}\n";
        echo "  -----------\n";
    }
    echo "\n";
}

// 3. Vérifier les opérateurs disponibles
echo "3. OPÉRATEURS MOBILE MONEY DISPONIBLES\n";
echo "---------------------------------------\n";

$operateurs = [
    '🇧🇯 Bénin' => ['mtn_benin', 'moov_benin'],
    '🇧🇫 Burkina Faso' => ['orange_burkina'],
    '🇨🇮 Côte d\'Ivoire' => ['mtn_ci', 'moov_ci', 'orange_ci', 'wave_ci'],
    '🇲🇱 Mali' => ['orange_mali'],
    '🇹🇬 Togo' => ['tmoney_togo', 'moov_togo'],
    '🇸🇳 Sénégal' => ['orange_senegal', 'free_senegal', 'emoney_senegal', 'wave_senegal'],
];

foreach ($operateurs as $pays => $ops) {
    echo "{$pays}:\n";
    foreach ($ops as $op) {
        echo "  • {$op}\n";
    }
}

echo "\nTotal: 14 opérateurs\n\n";

// 4. Statistiques des retraits
echo "4. STATISTIQUES DES RETRAITS\n";
echo "----------------------------\n";

$stats = DB::table('retraits')
    ->select(
        DB::raw('COUNT(*) as total'),
        DB::raw('SUM(montant) as montant_total'),
        DB::raw('COUNT(CASE WHEN statut = "en_attente" THEN 1 END) as en_attente'),
        DB::raw('COUNT(CASE WHEN statut = "en_cours" THEN 1 END) as en_cours'),
        DB::raw('COUNT(CASE WHEN statut = "traite" THEN 1 END) as traite'),
        DB::raw('COUNT(CASE WHEN statut = "annule" THEN 1 END) as annule')
    )
    ->first();

echo "Total des retraits: {$stats->total}\n";
echo "Montant total: " . number_format($stats->montant_total ?? 0, 0, ',', ' ') . " F CFA\n";
echo "\nPar statut:\n";
echo "  • En attente: {$stats->en_attente}\n";
echo "  • En cours: {$stats->en_cours}\n";
echo "  • Traités: {$stats->traite}\n";
echo "  • Annulés: {$stats->annule}\n";

echo "\n========================================\n";
echo "TEST TERMINÉ AVEC SUCCÈS ✓\n";
echo "========================================\n\n";
