<?php
// Compare French and Turkish email translation files and report missing/placeholder keys

require __DIR__ . '/../vendor/autoload.php';

$frPath = __DIR__ . '/../resources/lang/fr/emails.php';
$trPath = __DIR__ . '/../resources/lang/tr/emails.php';

if (!file_exists($frPath)) {
    echo "Fichier FR introuvable: $frPath\n";
    exit(1);
}
if (!file_exists($trPath)) {
    echo "Fichier TR introuvable: $trPath\n";
    exit(1);
}

function parseLangFile($path) {
    $text = file_get_contents($path);
    $results = [];

    // Match 'key' => 'value' or "key" => "value" (single or double quoted)
    if (preg_match_all('/["\']([^"\']+)["\']\s*=>\s*(["\'])(.*?)\2/s', $text, $m, PREG_SET_ORDER)) {
        foreach ($m as $match) {
            $key = $match[1];
            $val = $match[3];
            // Unescape simple escaped quotes
            $val = str_replace(["\\'", '\\"'], ["'", '"'], $val);
            $results[$key] = $val;
        }
    }

    return $results;
}

$fr = parseLangFile($frPath);
$tr = parseLangFile($trPath);

$missing = [];
$placeholders = [];
$ok = [];

foreach ($fr as $key => $frValue) {
    if (!array_key_exists($key, $tr)) {
        $missing[] = $key;
        continue;
    }
    $trValue = $tr[$key];
    // Normalize whitespace for comparison
    $a = trim(preg_replace('/\s+/', ' ', strip_tags((string)$frValue)));
    $b = trim(preg_replace('/\s+/', ' ', strip_tags((string)$trValue)));

    if ($a === $b) {
        $placeholders[] = $key;
    } else {
        $ok[] = $key;
    }
}

echo "Comparaison FR vs TR pour 'emails'\n";
echo "--------------------------------\n";
echo "Total clés FR: " . count($fr) . "\n";
echo "Clés présentes en TR: " . count($tr) . "\n";
echo "- OK (valeur différente du FR): " . count($ok) . "\n";
echo "- Placeholders (valeurs identiques au FR après strip_tags): " . count($placeholders) . "\n";
echo "- Manquantes: " . count($missing) . "\n\n";

if (count($missing) > 0) {
    echo "Clés manquantes en tr:\n";
    foreach ($missing as $k) {
        echo " - $k\n";
    }
    echo "\n";
}

if (count($placeholders) > 0) {
    echo "Clés avec placeholder (valeur identique au FR):\n";
    foreach ($placeholders as $k) {
        echo " - $k\n";
    }
    echo "\n";
}

if (count($ok) > 0) {
    echo "Exemples de clés traduites en tr (5 premiers):\n";
    $sample = array_slice($ok, 0, 5);
    foreach ($sample as $k) {
        echo " - $k\n";
    }
    echo "\n";
}

// Extras: keys present in TR but not in FR
$extra = array_diff(array_keys($tr), array_keys($fr));
if (count($extra) > 0) {
    echo "Clés présentes en TR mais pas en FR (éventuelles additions):\n";
    foreach ($extra as $k) echo " - $k\n";
}

exit(0);
