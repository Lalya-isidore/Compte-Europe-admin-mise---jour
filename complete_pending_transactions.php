<?php
// Script pour compléter manuellement les transactions pending
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== SCRIPT DE COMPLETION MANUELLE DES TRANSACTIONS ===" . PHP_EOL;

// Trouver toutes les transactions pending
$pendingTransactions = App\Models\RechargeTransaction::where('status', 'pending')
    ->orderBy('created_at', 'desc')
    ->get();

echo "Transactions pending trouvées: " . $pendingTransactions->count() . PHP_EOL . PHP_EOL;

foreach ($pendingTransactions as $transaction) {
    echo "Transaction ID: {$transaction->transaction_id}" . PHP_EOL;
    echo "User ID: {$transaction->user_id}" . PHP_EOL;
    echo "Montant: {$transaction->amount} F CFA" . PHP_EOL;
    echo "Crédits à ajouter: {$transaction->credits_earned}" . PHP_EOL;
    echo "Date: {$transaction->created_at}" . PHP_EOL;
    
    // Vérifier l'utilisateur
    $user = App\Models\User::find($transaction->user_id);
    if (!$user) {
        echo "❌ Utilisateur non trouvé" . PHP_EOL . PHP_EOL;
        continue;
    }
    
    $creditsBefore = $user->credit_user ?? 0;
    echo "Crédits avant: {$creditsBefore}" . PHP_EOL;
    
    try {
        // Commencer une transaction DB
        DB::beginTransaction();
        
        // Mettre à jour le statut de la transaction
        $transaction->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
        
        // Créditer les crédits utilisateur
        $user->credit_user = $creditsBefore + $transaction->credits_earned;
        $user->save();
        
        echo "✅ Crédits mis à jour: {$creditsBefore} → {$user->credit_user}" . PHP_EOL;
        
        // Traiter les commissions d'affiliation si applicable
        if ($user->parrain_id) {
            $parrainAffiliation = App\Models\Affiliation::where('user_id', $user->parrain_id)
                ->where('is_active', true)
                ->first();
            
            if ($parrainAffiliation) {
                $tauxCommission = $parrainAffiliation->commission_rate ?? 10;
                $montantCommission = ($transaction->amount * $tauxCommission) / 100;
                
                // Créer la commission
                $commission = App\Models\Commission::create([
                    'affiliation_id' => $parrainAffiliation->id,
                    'parraine_user_id' => $user->id,
                    'compte_id' => $transaction->compte_id,
                    'action_type' => 'recharge',
                    'montant_base' => $transaction->amount,
                    'taux_commission' => $tauxCommission,
                    'montant_commission' => $montantCommission,
                    'statut' => 'valide',
                    'date_action' => now(),
                    'date_validation' => now(),
                    'details' => [
                        'transaction_id' => $transaction->transaction_id,
                        'auto_processed' => true,
                        'manual_completion' => true
                    ]
                ]);
                
                // Créditer le parrain
                $parrainUser = App\Models\User::find($user->parrain_id);
                $parrainCompte = App\Models\Compte::where('user_id', $parrainUser->id)->first();
                
                if ($parrainCompte) {
                    $parrainCompte->increment('account_balance', $montantCommission);
                    echo "💰 Commission parrain: {$montantCommission} F CFA" . PHP_EOL;
                }
                
                $parrainAffiliation->increment('total_commissions', $montantCommission);
            }
        }
        
        DB::commit();
        echo "✅ Transaction complétée avec succès!" . PHP_EOL;
        
    } catch (Exception $e) {
        DB::rollback();
        echo "❌ Erreur: " . $e->getMessage() . PHP_EOL;
    }
    
    echo "---" . PHP_EOL . PHP_EOL;
}

echo "=== SCRIPT TERMINÉ ===" . PHP_EOL;
?>