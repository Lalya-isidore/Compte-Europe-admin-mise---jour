<?php
// Usage: php analyze_email_translations.php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$base = __DIR__ . '/../resources/lang';
$frFile = $base . '/fr/emails.php';
$enFile = $base . '/en/emails.php';

if (!file_exists($frFile)) { echo "FR file missing: $frFile\n"; exit(1); }
if (!file_exists($enFile)) { echo "EN file missing: $enFile\n"; exit(1); }

$fr = include $frFile;
$en = include $enFile;

$locales = array_filter(glob($base . '/*'), 'is_dir');
$report = [];

foreach ($locales as $localeDir) {
    $locale = basename($localeDir);
    $file = $localeDir . '/emails.php';
    if (!file_exists($file)) continue;
    $data = include $file;
    if (!is_array($data)) {
        $report[$locale] = ['error' => 'not_array'];
        continue;
    }
    $missing = [];
    $sameAsFr = [];
    $sameAsEn = [];
    $translated = [];
    foreach ($fr as $key => $frVal) {
        if (!array_key_exists($key, $data)) {
            $missing[] = $key;
            continue;
        }
        $val = $data[$key];
        if ($val === $frVal) {
            $sameAsFr[] = $key;
            continue;
        }
        if (array_key_exists($key, $en) && $val === $en[$key]) {
            $sameAsEn[] = $key;
            continue;
        }
        $translated[] = $key;
    }
    $report[$locale] = [
        'total_keys' => count($fr),
        'present' => count($fr) - count($missing),
        'missing' => count($missing),
        'same_as_fr' => count($sameAsFr),
        'same_as_en' => count($sameAsEn),
        'translated' => count($translated),
        'missing_keys' => $missing,
        'same_as_fr_keys' => $sameAsFr,
        'same_as_en_keys' => $sameAsEn,
    ];
}

// Print summary table
printf("Locale | present | missing | sameAsFR | sameAsEN | translated\n");
foreach ($report as $locale => $r) {
    if (isset($r['error'])) {
        printf("%s | ERROR: %s\n", $locale, $r['error']);
        continue;
    }
    printf("%s | %d | %d | %d | %d | %d\n", $locale, $r['present'], $r['missing'], $r['same_as_fr'], $r['same_as_en'], $r['translated']);
}

// Save detailed CSV
$csvFile = __DIR__ . '/email_translations_report.csv';
$fh = fopen($csvFile, 'w');
fputcsv($fh, ['locale','key','status']);
foreach ($report as $locale => $r) {
    if (isset($r['error'])) continue;
    foreach ($r['missing_keys'] as $k) fputcsv($fh, [$locale, $k, 'missing']);
    foreach ($r['same_as_fr_keys'] as $k) fputcsv($fh, [$locale, $k, 'same_as_fr']);
    foreach ($r['same_as_en_keys'] as $k) fputcsv($fh, [$locale, $k, 'same_as_en']);
    // translated keys: compute
    $translatedKeys = array_diff(array_keys($fr), $r['missing_keys'], $r['same_as_fr_keys'], $r['same_as_en_keys']);
    foreach ($translatedKeys as $k) fputcsv($fh, [$locale, $k, 'translated']);
}
fclose($fh);

echo "\nReport written to $csvFile\n";
