<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\RechargeTransaction;

echo "\n========================================\n";
echo "VÉRIFICATION DES NOUVEAUX TARIFS\n";
echo "========================================\n\n";

// Tester la méthode du modèle
echo "TEST 1: Méthode RechargeTransaction::calculateCredits()\n";
echo str_repeat("-", 60) . "\n";

$montants = [100, 5000, 10000, 25000, 50000];

foreach ($montants as $montant) {
    $credits = RechargeTransaction::calculateCredits($montant);
    $bonus = $credits - $montant;
    $bonusPercent = $montant > 0 ? (($bonus / $montant) * 100) : 0;
    
    printf("%-15s → %-20s (Bonus: %+d F, %+.0f%%)\n", 
        number_format($montant, 0, ',', ' ') . " F",
        number_format($credits, 0, ',', ' ') . " crédits",
        $bonus,
        $bonusPercent
    );
}

echo "\n";

// Vérification des valeurs attendues
echo "TEST 2: Vérification des valeurs attendues\n";
echo str_repeat("-", 60) . "\n";

$expected = [
    100 => 100,
    5000 => 5000,
    10000 => 15000,
    25000 => 40000,
    50000 => 100000,
];

$allCorrect = true;

foreach ($expected as $montant => $expectedCredits) {
    $actualCredits = RechargeTransaction::calculateCredits($montant);
    $status = ($actualCredits === $expectedCredits) ? "✓ OK" : "✗ ERREUR";
    
    if ($actualCredits !== $expectedCredits) {
        $allCorrect = false;
    }
    
    printf("%s | %s F → %s crédits (attendu: %s)\n",
        $status,
        number_format($montant, 0, ',', ' '),
        number_format($actualCredits, 0, ',', ' '),
        number_format($expectedCredits, 0, ',', ' ')
    );
}

echo "\n";

if ($allCorrect) {
    echo "✅ TOUS LES TESTS SONT PASSÉS AVEC SUCCÈS\n";
} else {
    echo "❌ CERTAINS TESTS ONT ÉCHOUÉ\n";
}

echo "\n========================================\n";
echo "RÉSUMÉ DES NOUVEAUX TARIFS\n";
echo "========================================\n\n";

$tarifs = [
    ['montant' => '100 F', 'credits' => '100 crédits', 'bonus' => '+0%'],
    ['montant' => '5 000 F', 'credits' => '5 000 crédits', 'bonus' => '+0%'],
    ['montant' => '10 000 F', 'credits' => '15 000 crédits', 'bonus' => '+50%'],
    ['montant' => '25 000 F', 'credits' => '40 000 crédits', 'bonus' => '+60%'],
    ['montant' => '50 000 F', 'credits' => '100 000 crédits', 'bonus' => '+100%'],
];

printf("%-15s | %-25s | %-10s\n", "Montant", "Crédits Reçus", "Bonus");
echo str_repeat("-", 60) . "\n";

foreach ($tarifs as $tarif) {
    printf("%-15s | %-25s | %-10s\n", 
        $tarif['montant'], 
        $tarif['credits'], 
        $tarif['bonus']
    );
}

echo "\n========================================\n";
echo "✓ VÉRIFICATION TERMINÉE\n";
echo "========================================\n\n";
