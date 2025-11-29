<?php
// Usage: php scripts/replace_fr_placeholders_with_en_in_europe.php
// For a curated list of European locales, replace values equal to FR placeholders
// with EN translations when available.

$base = __DIR__ . '/../';
$langDir = $base . 'resources/lang';
$fr = include $langDir . '/fr/emails.php';
$en = file_exists($langDir . '/en/emails.php') ? include $langDir . '/en/emails.php' : [];

// Curated European language codes (common). Adjust as needed.
$europeLocales = [
    'en','fr','es','de','it','pt','nl','pl','sv','no','da','fi','cs','sk','hu','ro','bg','el','hr','sr','sl','lt','lv','et','is','mk','mt','ga','cy','sq','be','uk','ru','tr','al' // 'al' is not standard locale but kept optional
];

// Normalize existing lang directories
$existing = [];
foreach (new DirectoryIterator($langDir) as $d) {
    if($d->isDir() && !$d->isDot()) $existing[] = $d->getFilename();
}

$processed = [];
foreach ($europeLocales as $loc) {
    if (!in_array($loc, $existing)) continue;
    if ($loc === 'fr' || $loc === 'en') continue;

    $path = $langDir . '/' . $loc . '/emails.php';
    if (!file_exists($path)) continue;
    $arr = include $path;
    if (!is_array($arr)) continue;

    $changed = 0;
    foreach ($fr as $key => $frValue) {
        if (!array_key_exists($key, $arr)) continue; // nothing to replace
        // treat placeholder when locale value exactly equals FR
        if ($arr[$key] === $frValue) {
            if (array_key_exists($key, $en) && $en[$key] !== '') {
                $arr[$key] = $en[$key];
                $changed++;
            }
            // else leave FR value as-is
        }
    }

    if ($changed > 0) {
        $content = '<?php\n\nreturn ' . var_export($arr, true) . ";\n";
        file_put_contents($path, $content);
    }

    $processed[$loc] = $changed;
}

echo "Processed locales: " . count($processed) . "\n";
foreach ($processed as $loc => $count) echo " - $loc : replaced $count placeholders\n";

exit(0);
