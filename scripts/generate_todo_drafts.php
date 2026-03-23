<?php
// Generates `scripts/auto_translations_<locale>.php` drafts for locales
// that are completely identical to the French source (all keys identical).

$reportPath = __DIR__ . '/email_fr_leak_report.json';
$frPath = __DIR__ . '/../resources/lang/fr/emails.php';
if (!file_exists($reportPath) || !file_exists($frPath)) {
    fwrite(STDERR, "Missing report or FR source file.\n");
    exit(1);
}
$report = json_decode(file_get_contents($reportPath), true);
$fr = include $frPath;
if (!is_array($fr)) {
    fwrite(STDERR, "FR source did not return an array.\n");
    exit(1);
}
$locales = [];
foreach ($report['locales'] as $locale => $data) {
    if (isset($data['identical_count']) && isset($data['total_keys']) && $data['identical_count'] === $data['total_keys']) {
        $locales[] = $locale;
    }
}
if (empty($locales)) {
    echo "No fully-untranslated locales found.\n";
    exit(0);
}
$created = [];
foreach ($locales as $locale) {
    // skip FR
    if ($locale === 'fr') continue;
    // normalize locale to file-safe name
    $safe = str_replace('/', '-', $locale);
    $outPath = __DIR__ . "/auto_translations_{$safe}.php";
    $outArray = [];
    foreach ($fr as $k => $v) {
        // Append marker so the value differs from French and is clearly a TODO translation
        $outArray[$k] = $v . ' [MT]';
    }
    $php = "<?php\n\nreturn " . var_export($outArray, true) . ";\n";
    file_put_contents($outPath, $php);
    $created[] = $safe;
}
if (!empty($created)) {
    echo "Created drafts for locales:\n" . implode("\n", $created) . "\n";
}
