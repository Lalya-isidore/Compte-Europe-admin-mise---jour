<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Compte;
use Illuminate\Support\Facades\Hash;

echo "\n========================================\n";
echo "VÉRIFICATION DES MOTS DE PASSE COMPTES\n";
echo "========================================\n\n";

$comptes = Compte::orderBy('created_at', 'desc')->limit(10)->get();

echo "📊 DERNIERS COMPTES CRÉÉS\n";
echo "----------------------------------------\n\n";

foreach ($comptes as $compte) {
    echo "Compte #{$compte->id}\n";
    echo "  Nom : {$compte->nom} {$compte->prenom}\n";
    echo "  Email : {$compte->email}\n";
    echo "  Mot de passe stocké : {$compte->password}\n";
    
    // Vérifier si c'est un hash bcrypt
    $isHashed = preg_match('/^\$2[ayb]\$.{56}$/', $compte->password);
    
    if ($isHashed) {
        echo "  Format : ✅ HASHÉ (bcrypt)\n";
        echo "  Connexion : ✅ Fonctionnera avec Hash::check()\n";
    } else {
        echo "  Format : ❌ EN CLAIR (non hashé)\n";
        echo "  Connexion : ❌ NE FONCTIONNERA PAS avec Hash::check()\n";
        echo "  Solution : Utiliser comparaison directe ou hasher le mot de passe\n";
    }
    
    echo "  Auto-créé : " . ($compte->is_auto_created ? "Oui" : "Non") . "\n";
    echo "  Créé le : " . $compte->created_at->format('d/m/Y H:i') . "\n";
    echo "\n";
}

echo "========================================\n";
echo "ANALYSE\n";
echo "========================================\n\n";

$totalComptes = Compte::count();
$comptesAutoCreated = Compte::where('is_auto_created', true)->count();
$comptesManual = $totalComptes - $comptesAutoCreated;

echo "Total comptes : {$totalComptes}\n";
echo "  • Créés manuellement : {$comptesManual}\n";
echo "  • Auto-créés : {$comptesAutoCreated}\n\n";

echo "⚠️  PROBLÈME IDENTIFIÉ\n";
echo "----------------------------------------\n";
echo "Le système de connexion utilise Hash::check() mais les mots de passe\n";
echo "sont stockés EN CLAIR dans la base de données.\n\n";

echo "🔧 SOLUTIONS POSSIBLES\n";
echo "----------------------------------------\n";
echo "1. Modifier la connexion pour accepter les mots de passe en clair\n";
echo "2. Hasher les mots de passe lors de la création\n";
echo "3. Ajouter un mutateur dans le modèle Compte\n\n";

echo "Pour tester la connexion d'un compte :\n";
echo "  Email : {$comptes->first()->email}\n";
echo "  Mot de passe : {$comptes->first()->password}\n\n";

echo "========================================\n\n";
