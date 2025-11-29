<?php
/**
 * Script de mise à jour du taux de commission d'affiliation
 * Change tous les taux de 10% à 5%
 * 
 * IMPORTANT: Exécuter ce script une seule fois après déploiement
 * Usage: php update_commission_rate.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Affiliation;
use App\Models\Commission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

echo "\n=== MISE À JOUR DU TAUX DE COMMISSION D'AFFILIATION ===\n";
echo "Ancien taux: 10%\n";
echo "Nouveau taux: 5%\n\n";

try {
    DB::beginTransaction();
    
    // 1. Compter les affiliations concernées
    $affiliationsCount = Affiliation::where('commission_rate', 10.00)->count();
    echo "Nombre d'affiliations à mettre à jour: {$affiliationsCount}\n";
    
    if ($affiliationsCount === 0) {
        echo "Aucune affiliation à mettre à jour.\n";
        DB::rollBack();
        exit(0);
    }
    
    // 2. Demander confirmation
    echo "\nVoulez-vous continuer? (oui/non): ";
    $confirmation = trim(fgets(STDIN));
    
    if (strtolower($confirmation) !== 'oui') {
        echo "Opération annulée.\n";
        DB::rollBack();
        exit(0);
    }
    
    // 3. Mettre à jour les affiliations
    echo "\n--- Mise à jour des affiliations ---\n";
    $updated = Affiliation::where('commission_rate', 10.00)
        ->update(['commission_rate' => 5.00]);
    
    echo "✓ {$updated} affiliation(s) mise(s) à jour\n";
    
    // 4. Afficher un rapport détaillé
    echo "\n--- Rapport détaillé ---\n";
    $affiliations = Affiliation::where('commission_rate', 5.00)->get();
    
    foreach ($affiliations as $affiliation) {
        echo "- User ID: {$affiliation->user_id}, Code: {$affiliation->code_affiliation}, Nouveau taux: {$affiliation->commission_rate}%\n";
    }
    
    // 5. Vérifier les commissions futures (info seulement)
    echo "\n--- Informations sur les commissions ---\n";
    $totalCommissions = Commission::count();
    $commissionsEnAttente = Commission::where('statut', 'en_attente')->count();
    $commissionsValides = Commission::where('statut', 'valide')->count();
    
    echo "Total de commissions existantes: {$totalCommissions}\n";
    echo "- En attente: {$commissionsEnAttente}\n";
    echo "- Validées: {$commissionsValides}\n";
    echo "\nNOTE: Les commissions existantes conservent leur montant calculé avec l'ancien taux.\n";
    echo "Seules les NOUVELLES commissions utiliseront le taux de 5%.\n";
    
    // 6. Logger l'opération
    Log::info('Commission rate updated from 10% to 5%', [
        'affiliations_updated' => $updated,
        'timestamp' => now(),
        'script' => 'update_commission_rate.php'
    ]);
    
    DB::commit();
    
    echo "\n✓ MISE À JOUR TERMINÉE AVEC SUCCÈS!\n";
    echo "Les nouvelles affiliations et recharges utiliseront maintenant le taux de 5%.\n\n";
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\n✗ ERREUR: " . $e->getMessage() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
    echo "Fichier: " . $e->getFile() . "\n\n";
    
    Log::error('Failed to update commission rate', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    exit(1);
}
