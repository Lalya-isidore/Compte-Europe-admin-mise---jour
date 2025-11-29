<?php

use Illuminate\Support\Facades\DB;

// Script pour ajouter des gains de test

try {
    // Récupérer le premier utilisateur
    $user = DB::table('users')->first();
    
    if (!$user) {
        echo "Aucun utilisateur trouvé.\n";
        exit;
    }
    
    echo "Utilisateur trouvé: {$user->nom} {$user->prenom} (ID: {$user->id})\n";
    
    // Vérifier s'il a une affiliation
    $affiliation = DB::table('affiliations')->where('user_id', $user->id)->first();
    
    if (!$affiliation) {
        // Créer une affiliation
        $affiliationId = DB::table('affiliations')->insertGetId([
            'user_id' => $user->id,
            'code_affiliation' => 'TEST' . $user->id,
            'commission_rate' => 10.0,
            'is_active' => true,
            'total_parraines' => 0,
            'total_commissions' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        echo "Affiliation créée (ID: {$affiliationId})\n";
    } else {
        $affiliationId = $affiliation->id;
        echo "Affiliation existante (ID: {$affiliationId})\n";
    }
    
    // Créer une commission de test de 5000 F CFA
    $commissionId = DB::table('commissions')->insertGetId([
        'affiliation_id' => $affiliationId,
        'parraine_user_id' => $user->id, // Pour simplifier, même utilisateur
        'action_type' => 'recharge',
        'montant_base' => 50000, // Base de 50000 pour avoir 5000 de commission
        'taux_commission' => 10,
        'montant_commission' => 5000,
        'statut' => 'validee',
        'date_action' => now(),
        'date_validation' => now(),
        'details' => json_encode(['test' => true, 'description' => 'Commission de test']),
        'created_at' => now(),
        'updated_at' => now()
    ]);
    
    echo "Commission de test créée: 5000 F CFA (ID: {$commissionId})\n";
    
    // Mettre à jour le total des commissions de l'affiliation
    DB::table('affiliations')
        ->where('id', $affiliationId)
        ->update([
            'total_commissions' => DB::raw('total_commissions + 5000'),
            'updated_at' => now()
        ]);
    
    echo "Total des commissions mis à jour.\n";
    echo "L'utilisateur devrait maintenant avoir 5000 F CFA de gains disponibles!\n";
    
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}