<?php
// Réécrit les fichiers resources/lang/*/emails.php qui contiennent des séquences
// littérales "\\n" au lieu de vrais sauts de ligne. Utilise une parsing
// simple pour extraire les paires clé=>valeur et réécrit le fichier en PHP
// lisible.

function parseLangFileRaw($path) {
    $text = file_get_contents($path);
    $results = [];

    // Match 'key' => 'value' or "key" => "value"
    if (preg_match_all('/["\']([^"\']+)["\']\s*=>\s*(["\'])(.*?)\2/s', $text, $m, PREG_SET_ORDER)) {
        foreach ($m as $match) {
            $key = $match[1];
            $val = $match[3];
            // Unescape escaped quotes
            $val = str_replace(["\\'", '\\"'], ["'", '"'], $val);
            // Convert literal \n and \r into real newlines inside strings
            $val = str_replace(['\\n','\\r','\\t'], ["\n","\r","\t"], $val);
            $results[$key] = $val;
        }
    }
    return $results;
}

function writeLangFile($path, $arr) {
    $out = "<?php\n\nreturn [\n";
    foreach ($arr as $k => $v) {
        // escape single quotes and backslashes
        $escaped = str_replace(['\\', "'"], ['\\\\', "\\'"], $v);
        $out .= "    '" . $k . "' => '" . $escaped . "',\n";
    }
    $out .= "];\n";
    file_put_contents($path, $out);
}

$files = glob(__DIR__ . '/../resources/lang/*/emails.php');
$fixed = [];
$skipped = [];

foreach ($files as $f) {
    $contents = file_get_contents($f);
    if (strpos($contents, '\\n') !== false) {
        echo "Corrige : $f\n";
        $parsed = parseLangFileRaw($f);
        if (count($parsed) === 0) {
            echo "  Impossible d'extraire les clés depuis le fichier, saut.\n";
            $skipped[] = $f;
            continue;
        }
        writeLangFile($f, $parsed);
        $fixed[] = $f;
    }
}

echo "Fix terminé. Fichiers modifiés: " . count($fixed) . ", sautés: " . count($skipped) . "\n";
