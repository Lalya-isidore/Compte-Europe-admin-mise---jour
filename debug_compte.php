<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$id = $argv[1] ?? null;
if (! $id) {
    echo "Usage: php debug_compte.php <id>\n";
    exit(1);
}

use Illuminate\Support\Facades\Storage;
use App\Models\Compte;

$compte = Compte::find($id);
if (! $compte) {
    echo "NOT_FOUND\n";
    exit(0);
}

$photoPath = $compte->photo_path;
$photoUrl = $photoPath ? Storage::disk('public')->url($photoPath) : null;
$diskExists = $photoPath ? Storage::disk('public')->exists($photoPath) : false;
$serverPath = $diskExists ? Storage::disk('public')->path($photoPath) : null;
$isReadable = $serverPath ? is_readable($serverPath) : false;
$size = $diskExists ? Storage::disk('public')->size($photoPath) : null;
$lastModified = $serverPath && file_exists($serverPath) ? date('c', filemtime($serverPath)) : null;

$output = [
    'compte_id' => $compte->id,
    'user_id' => $compte->user_id,
    'photo_path' => $photoPath,
    'photo_url' => $photoUrl,
    'disk_exists' => $diskExists,
    'server_path' => $serverPath,
    'is_readable' => $isReadable,
    'size_bytes' => $size,
    'last_modified' => $lastModified,
];

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
