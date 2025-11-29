<?php
// Script simple pour voir les logs récents
$logFile = __DIR__ . '/storage/logs/laravel.log';

if (!file_exists($logFile)) {
    echo "Fichier log non trouvé: $logFile\n";
    exit;
}

echo "=== LOGS RÉCENTS (30 dernières lignes) ===" . PHP_EOL;
$logs = file_get_contents($logFile);
$lines = explode("\n", $logs);
$recentLines = array_slice($lines, -30);

foreach ($recentLines as $line) {
    if (strpos($line, 'commission') !== false || 
        strpos($line, 'affiliation') !== false || 
        strpos($line, 'Starting commission') !== false ||
        strpos($line, 'parrain') !== false) {
        echo $line . PHP_EOL;
    }
}
?>