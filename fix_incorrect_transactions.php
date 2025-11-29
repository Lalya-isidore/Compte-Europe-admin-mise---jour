<?php
// Script pour corriger les transactions incorrectement validées
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CORRECTION DES TRANSACTIONS INCORRECTEMENT VALIDÉES ===" . PHP_EOL;

// IDs des transactions réellement payées (selon FedaPay)
$reallyPaidTransactions = [
    'RCRZO1WSNX1762171910', // 100 F CFA - 13:11:51
    'RCWDO1HL0L1762171544'  // 100 F CFA - 13:05:45
];

// IDs des transactions non payées (en attente sur FedaPay)
$unpaidTransactions = [
    'RC6U9KHWE51762171299',  // 5000 F CFA
    'RC6MXF2YCM1762170923',  // 5000 F CFA  
    'RCRIJM5HZB1762170647',  // 5000 F CFA
    'RCEF9UYVSL1762170408'   // 5000 F CFA
];

echo "Transactions réellement payées: " . count($reallyPaidTransactions) . PHP_EOL;
echo "Transactions non payées à corriger: " . count($unpaidTransactions) . PHP_EOL . PHP_EOL;

$user = App\Models\User::find(13); // Votre user_id
$creditsBefore = $user->credit_user ?? 0;
echo "Crédits utilisateur avant correction: {$creditsBefore}" . PHP_EOL;

$totalCreditsToRemove = 0;
$totalCommissionsToRemove = 0;

try {
    DB::beginTransaction();
    
    // 1. Corriger les transactions non payées
    foreach ($unpaidTransactions as $transactionId) {
        $transaction = App\Models\RechargeTransaction::where('transaction_id', $transactionId)->first();
        
        if ($transaction && $transaction->status === 'completed') {
            echo "Correction transaction: {$transactionId}" . PHP_EOL;
            echo "  - Montant: {$transaction->amount} F CFA" . PHP_EOL;
            echo "  - Crédits à retirer: {$transaction->credits_earned}" . PHP_EOL;
            
            // Remettre en pending
            $transaction->update([
                'status' => 'pending',
                'completed_at' => null
            ]);
            
            $totalCreditsToRemove += $transaction->credits_earned;
            
            // Supprimer les commissions associées
            $commissions = App\Models\Commission::where('details->transaction_id', $transactionId)->get();
            foreach ($commissions as $commission) {
                echo "  - Commission à annuler: {$commission->montant_commission} F CFA" . PHP_EOL;
                $totalCommissionsToRemove += $commission->montant_commission;
                
                // Retirer la commission du parrain
                if ($commission->affiliation && $commission->affiliation->user) {
                    $parrainUser = $commission->affiliation->user;
                    $parrainCompte = App\Models\Compte::where('user_id', $parrainUser->id)->first();
                    if ($parrainCompte) {
                        $parrainCompte->decrement('account_balance', $commission->montant_commission);
                    }
                }
                
                // Supprimer la commission
                $commission->delete();
            }
        }
    }
    
    // 2. Corriger les crédits utilisateur
    $user->credit_user = $creditsBefore - $totalCreditsToRemove;
    $user->save();
    
    DB::commit();
    
    echo PHP_EOL . "=== CORRECTION TERMINÉE ===" . PHP_EOL;
    echo "Crédits retirés: {$totalCreditsToRemove}" . PHP_EOL;
    echo "Crédits utilisateur après correction: {$user->credit_user}" . PHP_EOL;
    echo "Commissions annulées: {$totalCommissionsToRemove} F CFA" . PHP_EOL;
    echo "✅ Les transactions non payées sont remises en 'pending'" . PHP_EOL;
    
} catch (Exception $e) {
    DB::rollback();
    echo "❌ Erreur: " . $e->getMessage() . PHP_EOL;
}
?>