<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Compte;

echo "\n========================================\n";
echo "CONFIGURATION DES ALERTES SMS\n";
echo "========================================\n\n";

echo "📱 SYSTÈME D'ALERTE SMS UNIQUE\n";
echo "----------------------------------------\n\n";

echo "✅ SMS D'OUVERTURE UNIQUEMENT\n";
echo "  • Si l'option 'Alerte par SMS' est cochée lors de la création\n";
echo "  • UN SEUL SMS est envoyé : le message d'ouverture avec identifiants\n";
echo "  • Contenu identique à l'email d'ouverture :\n";
echo "    - Nom et prénom\n";
echo "    - Email de connexion\n";
echo "    - Mot de passe\n";
echo "    - Solde initial\n";
echo "  • Envoyé vers : Le numéro de téléphone du compte\n";
echo "  • Coût : 1 000 crédits (prélevés lors de la création)\n\n";

echo "📧 TOUTES LES AUTRES NOTIFICATIONS PAR EMAIL\n";
echo "  • Notification de virement\n";
echo "  • Validation de virement\n";
echo "  • Échec de virement\n";
echo "  • Code de déblocage\n";
echo "  • Changement de solde\n";
echo "  • Blocage/Déblocage du compte\n";
echo "  • Remboursement\n\n";

echo "⚙️ COMPORTEMENT ACTUEL\n";
echo "----------------------------------------\n\n";

$totalComptes = Compte::count();
$comptesAvecSMS = Compte::where('alert_sms', true)->count();
$comptesSansSMS = Compte::where('alert_sms', false)->count();

echo "Total des comptes : {$totalComptes}\n";
echo "  • Avec SMS d'ouverture : {$comptesAvecSMS}\n";
echo "  • Sans SMS d'ouverture : {$comptesSansSMS}\n\n";

if ($comptesAvecSMS > 0) {
    echo "📋 COMPTES AVEC SMS D'OUVERTURE\n";
    echo "----------------------------------------\n";
    
    $comptes = Compte::where('alert_sms', true)->with('user')->get();
    
    foreach ($comptes as $compte) {
        echo "\n  Compte #{$compte->id}\n";
        echo "    Nom : {$compte->nom} {$compte->prenom}\n";
        echo "    Email : {$compte->email}\n";
        echo "    Téléphone : {$compte->phone_number}\n";
        echo "    Créé le : " . $compte->created_at->format('d/m/Y à H:i') . "\n";
        echo "    SMS d'ouverture : ✅ Envoyé\n";
        echo "    Autres notifications : 📧 Email uniquement\n";
    }
}

echo "\n\n💰 COÛTS DE CRÉATION\n";
echo "----------------------------------------\n";
echo "  • Sans SMS : 3 500 crédits\n";
echo "  • Avec SMS d'ouverture : 4 500 crédits (3 500 + 1 000)\n\n";

echo "📝 NOTES IMPORTANTES\n";
echo "----------------------------------------\n";
echo "  1. Le SMS d'ouverture est UNIQUE et ne se répète jamais\n";
echo "  2. Le champ 'alert_sms' dans la base de données indique si le SMS a été envoyé\n";
echo "  3. Aucune autre notification ne déclenche d'envoi de SMS\n";
echo "  4. Tous les emails passent par SafeMailService (fiabilité garantie)\n\n";

echo "========================================\n\n";
