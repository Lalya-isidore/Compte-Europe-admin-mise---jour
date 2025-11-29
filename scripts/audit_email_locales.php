<?php
// Usage: php scripts/audit_email_locales.php
// Génère : scripts/email_locales_report.json

$base = __DIR__ . '/../resources/lang';
$frFile = $base . '/fr/emails.php';
if (!file_exists($frFile)) {
    fwrite(STDERR, "Fichier de référence introuvable: $frFile\n");
    exit(2);
}
$fr = include $frFile;
if (!is_array($fr)) {
    fwrite(STDERR, "Le fichier FR ne retourne pas un tableau.\n");
    exit(2);
}
$frKeys = array_keys($fr);
$report = [];
$files = glob($base . '/*/emails.php');
foreach ($files as $file) {
    $locale = basename(dirname($file));
    $data = @include $file;
    if (!is_array($data)) {
        $report[$locale] = [
            'path' => $file,
            'status' => 'invalid',
            'missing' => $frKeys,
            'extra' => [],
            'identical' => false,
        ];
        continue;
    }
    $keys = array_keys($data);
    $missing = array_values(array_diff($frKeys, $keys));
    $extra = array_values(array_diff($keys, $frKeys));
    $identical = ($data === $fr);
    $report[$locale] = [
        'path' => $file,
        'status' => count($missing) === 0 ? 'complete' : 'incomplete',
        'missing' => $missing,
        'extra' => $extra,
        'identical' => $identical,
        'keys_count' => count($keys),
    ];
}

$pathOut = __DIR__ . '/email_locales_report.json';
file_put_contents($pathOut, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Summary
$complete = 0; $incomplete = 0; $invalid = 0; $identicalCount = 0;
foreach ($report as $locale => $info) {
    if ($info['status'] === 'complete') $complete++;
    if ($info['status'] === 'incomplete') $incomplete++;
    if ($info['status'] === 'invalid') $invalid++;
    if (!empty($info['identical'])) $identicalCount++;
}

echo "Audit des locales emails\n";
echo "Fichier FR utilisé: $frFile\n";
echo "Locales scannées: " . count($report) . "\n";
echo "  complete: $complete\n";
echo "  incomplete: $incomplete\n";
echo "  invalid: $invalid\n";
echo "  identical to fr: $identicalCount\n";
echo "Rapport complet généré: $pathOut\n";

// Print small table of locales with missing counts
echo "\nLocales incomplètes (locale => missing_count):\n";
$lines = [];
foreach ($report as $locale => $info) {
    if ($info['status'] === 'incomplete') {
        $lines[] = sprintf("%s => %d", $locale, count($info['missing']));
    }
}
if (empty($lines)) {
    echo "  (aucune)\n";
} else {
    foreach ($lines as $l) echo "  " . $l . "\n";
}

exit(0);
