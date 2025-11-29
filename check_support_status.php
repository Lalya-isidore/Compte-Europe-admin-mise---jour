<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Cache;

echo "\n========================================\n";
echo "VÉRIFICATION DU STATUT SUPPORT\n";
echo "========================================\n\n";

// Vérifier le cache
$cachedActivity = Cache::get('support_admin_last_active');

if ($cachedActivity) {
    echo "✓ Cache trouvé : support_admin_last_active\n";
    echo "  Valeur : " . $cachedActivity . "\n";
    echo "  Différence avec maintenant : " . now()->diffForHumans($cachedActivity) . "\n\n";
    
    $diffInMinutes = now()->diffInMinutes($cachedActivity);
    
    if ($diffInMinutes <= 5) {
        echo "  Statut affiché : ⚪ Actif maintenant • Réponse sous 24h\n";
        echo "  Badge LIVE : ✅ Visible\n\n";
    } elseif ($diffInMinutes < 60) {
        echo "  Statut affiché : 🟡 Actif il y a {$diffInMinutes} minute(s) • Réponse sous 24h\n";
        echo "  Badge LIVE : ❌ Masqué\n\n";
    } elseif ($diffInMinutes < 1440) {
        $hours = (int) floor($diffInMinutes / 60);
        echo "  Statut affiché : 🟠 Actif il y a {$hours} heure(s) • Réponse sous 24h\n";
        echo "  Badge LIVE : ❌ Masqué\n\n";
    } else {
        echo "  Statut affiché : 🔴 Délai de réponse : 24h maximum\n";
        echo "  Badge LIVE : ❌ Masqué\n\n";
    }
    
    echo "Pour effacer le cache manuellement :\n";
    echo "  php artisan cache:forget support_admin_last_active\n\n";
} else {
    echo "✓ Aucun cache trouvé\n";
    echo "  Statut affiché : 🔴 Délai de réponse : 24h maximum\n";
    echo "  Badge LIVE : ❌ Masqué\n\n";
}

// Vérifier la session admin
if (session()->has('admin_authenticated')) {
    echo "⚠️  Session admin active détectée\n";
    echo "  Email : " . session('admin_email', 'N/A') . "\n";
    echo "  Connecté depuis : " . (session('admin_login_time') ? session('admin_login_time')->diffForHumans() : 'N/A') . "\n\n";
} else {
    echo "✓ Aucune session admin active\n\n";
}

echo "========================================\n\n";
