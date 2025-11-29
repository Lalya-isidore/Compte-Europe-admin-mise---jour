<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

// Configuration de la base de données
$config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'compteeurope',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'strict' => true,
    'engine' => null,
];

try {
    // Connexion directe à MySQL
    $pdo = new PDO("mysql:host=localhost;dbname=compteeurope", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie.\n";
    
    // Récupérer le premier utilisateur
    $stmt = $pdo->query("SELECT * FROM users LIMIT 1");
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    
    if (!$user) {
        echo "Aucun utilisateur trouvé.\n";
        exit;
    }
    
    echo "Utilisateur trouvé: {$user->nom} {$user->prenom} (ID: {$user->id})\n";
    
    // Vérifier s'il a une affiliation
    $stmt = $pdo->prepare("SELECT * FROM affiliations WHERE user_id = ?");
    $stmt->execute([$user->id]);
    $affiliation = $stmt->fetch(PDO::FETCH_OBJ);
    
    if (!$affiliation) {
        // Créer une affiliation
        $stmt = $pdo->prepare("
            INSERT INTO affiliations (user_id, code_affiliation, commission_rate, is_active, total_parraines, total_commissions, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $stmt->execute([$user->id, 'TEST' . $user->id, 10.0, 1, 0, 0]);
        $affiliationId = $pdo->lastInsertId();
        echo "Affiliation créée (ID: {$affiliationId})\n";
    } else {
        $affiliationId = $affiliation->id;
        echo "Affiliation existante (ID: {$affiliationId})\n";
    }
    
    // Créer une commission de test de 5000 F CFA
    $stmt = $pdo->prepare("
        INSERT INTO commissions (affiliation_id, parraine_user_id, action_type, montant_base, taux_commission, montant_commission, statut, date_action, date_validation, details, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, NOW(), NOW())
    ");
    
    $details = json_encode(['test' => true, 'description' => 'Commission de test de 5000 F CFA']);
    $stmt->execute([
        $affiliationId, 
        $user->id, 
        'recharge', 
        50000, // Base de 50000 pour avoir 5000 de commission
        10, 
        5000, 
        'validee', 
        $details
    ]);
    
    $commissionId = $pdo->lastInsertId();
    echo "Commission de test créée: 5000 F CFA (ID: {$commissionId})\n";
    
    // Mettre à jour le total des commissions de l'affiliation
    $stmt = $pdo->prepare("UPDATE affiliations SET total_commissions = total_commissions + 5000, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$affiliationId]);
    
    echo "Total des commissions mis à jour.\n";
    echo "L'utilisateur devrait maintenant avoir 5000 F CFA de gains disponibles!\n";
    echo "Allez sur /affiliation pour voir le changement d'interface.\n";
    
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}
?>