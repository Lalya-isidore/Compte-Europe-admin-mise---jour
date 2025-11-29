<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Compte;

echo "\n========================================\n";
echo "VÉRIFICATION DES PHOTOS\n";
echo "========================================\n\n";

$comptes = Compte::whereNotNull('photo_path')
    ->orderBy('created_at', 'desc')
    ->take(5)
    ->get();

echo "Comptes avec photos : " . $comptes->count() . "\n\n";

foreach ($comptes as $compte) {
    echo "ID: {$compte->id}\n";
    echo "  Nom: {$compte->nom} {$compte->prenom}\n";
    echo "  Photo Path: {$compte->photo_path}\n";
    
    // Vérifier si c'est une URL externe
    if (str_starts_with($compte->photo_path, 'http://') || str_starts_with($compte->photo_path, 'https://')) {
        echo "  Type: URL externe (ui-avatars)\n";
        echo "  URL complète: {$compte->photo_path}\n";
    } else {
        // C'est un fichier local
        echo "  Type: Fichier local\n";
        $fullPath = storage_path('app/public/' . $compte->photo_path);
        echo "  Chemin physique: {$fullPath}\n";
        echo "  Fichier existe: " . (file_exists($fullPath) ? "✓ OUI" : "✗ NON") . "\n";
        echo "  URL publique: " . asset('storage/' . $compte->photo_path) . "\n";
    }
    echo "\n";
}

echo "========================================\n\n";
