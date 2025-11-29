<?php
// Vérifie que chaque resources/lang/*/emails.php retourne bien un tableau
foreach (glob(__DIR__ . '/../resources/lang/*/emails.php') as $f) {
    try {
        $r = include $f;
    } catch (Throwable $e) {
        echo "$f => parse error: " . $e->getMessage() . PHP_EOL;
        continue;
    }
    if (!is_array($r)) {
        echo "$f => returns " . gettype($r) . PHP_EOL;
    }
}

echo "Vérification terminée." . PHP_EOL;
