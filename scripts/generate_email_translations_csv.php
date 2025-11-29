<?php

// Usage: php scripts/generate_email_translations_csv.php
// Produces scripts/email_translations_for_translators.csv

$base = __DIR__ . '/../';
$langDir = $base . 'resources/lang';
$sourceLocale = 'fr';
$sourcePath = $langDir . '/' . $sourceLocale . '/emails.php';
$outPath = __DIR__ . '/email_translations_for_translators.csv';

if (!file_exists($sourcePath)) {
    echo "Source file not found: $sourcePath\n";
    exit(2);
}

$fr = include $sourcePath;
if (!is_array($fr)) {
    echo "Source $sourcePath does not return an array\n";
    exit(2);
}

// gather locales
$locales = [];
$di = new DirectoryIterator($langDir);
foreach ($di as $entry) {
    if (!$entry->isDir() || $entry->isDot()) continue;
    $locale = $entry->getFilename();
    if ($locale === 'locales') continue;
    $locales[] = $locale;
}
sort($locales);

$fh = fopen($outPath, 'w');
if ($fh === false) {
    echo "Cannot open $outPath for writing\n";
    exit(2);
}

// header
fputcsv($fh, ['locale','key','locale_value','status','fr_value']);

$totalRows = 0;
$totalPlaceholders = 0;
$totalMissing = 0;

foreach ($locales as $locale) {
    $path = $langDir . '/' . $locale . '/emails.php';
    $localArr = [];
    if (file_exists($path)) {
        try {
            $localArr = include $path;
            if (!is_array($localArr)) $localArr = [];
        } catch (Throwable $e) {
            $localArr = [];
        }
    }

    foreach ($fr as $key => $frValue) {
        $localeValue = array_key_exists($key, $localArr) ? $localArr[$key] : '';
        $status = 'ok';
        if ($localeValue === '') {
            $status = 'missing';
            $totalMissing++;
        } elseif ($localeValue === $frValue) {
            $status = 'placeholder';
            $totalPlaceholders++;
        }
        // ensure strings for CSV
        if (is_array($localeValue)) $localeValue = json_encode($localeValue, JSON_UNESCAPED_UNICODE);
        if (is_array($frValue)) $frValue = json_encode($frValue, JSON_UNESCAPED_UNICODE);

        fputcsv($fh, [$locale, $key, $localeValue, $status, $frValue]);
        $totalRows++;
    }
}

fclose($fh);

echo "CSV generated: $outPath\n";
echo "Locales: " . count($locales) . "\n";
echo "Total rows: $totalRows\n";
echo "Placeholders (locale value equals FR): $totalPlaceholders\n";
echo "Missing keys (locale value empty): $totalMissing\n";

exit(0);
