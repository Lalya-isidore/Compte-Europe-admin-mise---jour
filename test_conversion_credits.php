<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n========================================\n";
echo "TEST CONVERSION GAINS → CRÉDITS\n";
echo "========================================\n\n";

// Fonction de calcul identique au contrôleur
function calculateCreditsFromAmount($montant)
{
    $paliers = [
        50000 => 100000,  // 50 000 F = 100 000 crédits (+100%)
        25000 => 40000,   // 25 000 F = 40 000 crédits (+60%)
        10000 => 15000,   // 10 000 F = 15 000 crédits (+50%)
        5000 => 5000,     // 5 000 F = 5 000 crédits (+0%)
        100 => 100,       // 100 F = 100 crédits (+0%)
    ];
    
    $montantRestant = $montant;
    $totalCredits = 0;
    
    foreach ($paliers as $palierMontant => $palierCredits) {
        while ($montantRestant >= $palierMontant) {
            $totalCredits += $palierCredits;
            $montantRestant -= $palierMontant;
        }
    }
    
    if ($montantRestant > 0) {
        $totalCredits += $montantRestant;
    }
    
    return $totalCredits;
}

// Tests avec les NOUVEAUX tarifs
$tests = [
    100 => 100,       // 100 F = 100 crédits (+0%)
    5000 => 5000,     // 5000 F = 5000 crédits (+0%)
    10000 => 15000,   // 10000 F = 15000 crédits (+50%)
    9000 => 9000,     // 5000→5000 + 4000→4000 = 9000 crédits (+0%)
    15000 => 20000,   // 10000→15000 + 5000→5000 = 20000 crédits (+33%)
    25000 => 40000,   // 25000 F = 40000 crédits (+60%)
    50000 => 100000,  // 50000 F = 100000 crédits (+100%)
];

echo "EXEMPLES DE CONVERSION:\n";
echo str_repeat("-", 60) . "\n";
printf("%-15s | %-20s | %-15s\n", "Gains (F CFA)", "Crédits Reçus", "Bonus");
echo str_repeat("-", 60) . "\n";

foreach ($tests as $montant => $expected) {
    $credits = calculateCreditsFromAmount($montant);
    $bonus = $credits - $montant;
    $bonusPercent = ($bonus / $montant) * 100;
    
    printf("%-15s | %-20s | +%s (%.0f%%)\n", 
        number_format($montant, 0, ',', ' ') . " F",
        number_format($credits, 0, ',', ' ') . " crédits",
        number_format($bonus, 0, ',', ' '),
        $bonusPercent
    );
}

echo str_repeat("-", 60) . "\n\n";

// Test détaillé pour 9000 F (le montant actuel de test)
echo "EXEMPLE DÉTAILLÉ: 9 000 F CFA\n";
echo str_repeat("-", 60) . "\n";

$montant = 9000;
$montantRestant = $montant;
$details = [];
$totalCredits = 0;

$paliers = [
    50000 => ['credits' => 100000, 'bonus' => '+100%'],
    25000 => ['credits' => 40000, 'bonus' => '+60%'],
    10000 => ['credits' => 15000, 'bonus' => '+50%'],
    5000 => ['credits' => 5000, 'bonus' => '+0%'],
    100 => ['credits' => 100, 'bonus' => '+0%'],
];

foreach ($paliers as $palierMontant => $palierInfo) {
    $count = 0;
    while ($montantRestant >= $palierMontant) {
        $count++;
        $totalCredits += $palierInfo['credits'];
        $montantRestant -= $palierMontant;
    }
    
    if ($count > 0) {
        $details[] = sprintf("%d × %s F = %s crédits %s", 
            $count, 
            number_format($palierMontant, 0, ',', ' '),
            number_format($count * $palierInfo['credits'], 0, ',', ' '),
            $palierInfo['bonus']
        );
    }
}

// Reste (si applicable)
if ($montantRestant > 0) {
    $totalCredits += $montantRestant;
    $details[] = sprintf("Reste: %s F = %s crédits (1:1)", 
        number_format($montantRestant, 0, ',', ' '),
        number_format($montantRestant, 0, ',', ' ')
    );
}

foreach ($details as $detail) {
    echo "  • $detail\n";
}

echo "\n";
echo "RÉSULTAT FINAL:\n";
echo "  Montant: " . number_format($montant, 0, ',', ' ') . " F CFA\n";
echo "  Crédits: " . number_format($totalCredits, 0, ',', ' ') . " crédits FlashBilan\n";
echo "  Bonus: +" . number_format($totalCredits - $montant, 0, ',', ' ') . " crédits (+" . number_format((($totalCredits - $montant) / $montant) * 100, 1) . "%)\n";

echo "\n========================================\n";
echo "✅ TEST TERMINÉ\n";
echo "========================================\n\n";

