<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Compte;
use Illuminate\Support\Facades\Storage;

$id = 81;
$compte = Compte::find($id);
if (! $compte) {
    echo "Compte not found\n";
    exit(0);
}
$pp = $compte->photo_path;
echo "photo_path: " . var_export($pp, true) . "\n";
if ($pp) {
    if (str_starts_with($pp, 'http://') || str_starts_with($pp, 'https://')) {
        echo "photo_url (absolute): $pp\n";
        echo "disk_exists: n/a\n";
    } else {
        try {
            $url = Storage::disk('public')->url($pp);
            echo "photo_url (storage disk): $url\n";
        } catch (Throwable $e) {
            echo "photo_url (storage disk): error - " . $e->getMessage() . "\n";
        }
        try {
            $exists = Storage::disk('public')->exists($pp);
            echo "disk_exists: " . ($exists ? '1' : '0') . "\n";
            if ($exists) {
                echo "server_path: " . Storage::disk('public')->path($pp) . "\n";
            }
        } catch (Throwable $e) {
            echo "disk_exists: error - " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "photo_path empty\n";
}
