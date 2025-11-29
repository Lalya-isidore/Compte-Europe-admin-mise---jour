<?php
// Usage: php scripts/summarize_email_csv.php
// Reads scripts/email_translations_for_translators.csv and outputs: 
// - locales with no missing keys
// - locales with no missing keys and no placeholders (fully translated)

$csv = __DIR__ . '/email_translations_for_translators.csv';
if (!file_exists($csv)) {
    echo "CSV not found: $csv\n";
    exit(2);
}

$fh = fopen($csv, 'r');
if (!$fh) {
    echo "Cannot open CSV\n";
    exit(2);
}

$header = fgetcsv($fh);
// expected: locale,key,locale_value,status,fr_value
$locales = [];
while (($row = fgetcsv($fh)) !== false) {
    if (count($row) < 5) continue;
    list($locale, $key, $localeValue, $status, $frValue) = $row;
    if (!isset($locales[$locale])) {
        $locales[$locale] = ['missing'=>0,'placeholders'=>0,'total'=>0];
    }
    $locales[$locale]['total']++;
    if ($status === 'missing') $locales[$locale]['missing']++;
    if ($status === 'placeholder') $locales[$locale]['placeholders']++;
}

fclose($fh);

$noMissing = [];
$fullyTranslated = [];

foreach ($locales as $loc => $stats) {
    if ($stats['missing'] === 0) $noMissing[] = $loc;
    if ($stats['missing'] === 0 && $stats['placeholders'] === 0) $fullyTranslated[] = $loc;
}

sort($noMissing);
sort($fullyTranslated);

echo "Locales with NO missing keys (have a value for every key):\n";
foreach ($noMissing as $l) echo " - $l (placeholders: {$locales[$l]['placeholders']})\n";

echo "\nLocales fully translated (no missing, no placeholders):\n";
if (count($fullyTranslated) === 0) {
    echo " (none)\n";
} else {
    foreach ($fullyTranslated as $l) echo " - $l\n";
}

// Summary counts
$totalLocales = count($locales);
$cntNoMissing = count($noMissing);
$cntFully = count($fullyTranslated);

echo "\nSummary: locales=$totalLocales, no_missing=$cntNoMissing, fully_translated=$cntFully\n";

// Write simple outputs to files for reference
file_put_contents(__DIR__.'/locales_no_missing.txt', implode("\n", $noMissing));
file_put_contents(__DIR__.'/locales_fully_translated.txt', implode("\n", $fullyTranslated));

exit(0);
