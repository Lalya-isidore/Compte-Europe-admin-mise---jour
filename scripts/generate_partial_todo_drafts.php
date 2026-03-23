<?php
// Generate `scripts/auto_translations_<locale>.php` containing only the keys
// that are identical to FR, for locales where 0 < identical_count < total_keys.
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
$created = [];
foreach ($report['locales'] as $locale => $data) {
    if (!isset($data['identical_count']) || $data['identical_count'] <= 0) continue;
    if (!isset($data['total_keys']) || $data['identical_count'] >= $data['total_keys']) continue; // skip fully untranslated or FR
    if (empty($data['identical_keys'])) continue;
    $safe = str_replace('/', '-', $locale);
    $outPath = __DIR__ . "/auto_translations_{$safe}.php";
    $outArray = [];
    foreach ($data['identical_keys'] as $k) {
        if (array_key_exists($k, $fr)) {
            $outArray[$k] = $fr[$k] . ' [MT]';
        }
    }
    if (empty($outArray)) continue;
    $php = "<?php\n\nreturn " . var_export($outArray, true) . ";\n";
    file_put_contents($outPath, $php);
    $created[] = $safe;
}
if (empty($created)) {
    echo "No partial drafts created.\n";
    exit(0);
}
echo "Created partial drafts for locales:\n" . implode("\n", $created) . "\n";
