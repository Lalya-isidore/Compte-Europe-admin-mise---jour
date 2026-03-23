<?php
if ($argc < 2) { echo "Usage: php scripts/print_locale_report.php <locale>\n"; exit(1); }
$loc = $argv[1];
$path = __DIR__ . '/email_fr_leak_report.json';
if (!file_exists($path)) { fwrite(STDERR, "Report not found: $path\n"); exit(1); }
$r = json_decode(file_get_contents($path), true);
if (!isset($r['locales'][$loc])) { fwrite(STDERR, "Locale not found in report: $loc\n"); exit(1); }
$entry = $r['locales'][$loc];
echo "Locale: $loc\n";
echo "total_keys: " . ($entry['total_keys'] ?? 'n/a') . "\n";
echo "identical_count: " . ($entry['identical_count'] ?? 'n/a') . "\n";
echo "identical_keys:\n";
if (!empty($entry['identical_keys'])) {
    foreach ($entry['identical_keys'] as $k) echo "  - $k\n";
} else {
    echo "  (none)\n";
}
if (!empty($entry['french_substrings'])) {
    echo "french_substrings:\n";
    foreach ($entry['french_substrings'] as $key => $arr) {
        echo "  $key: " . implode(', ', $arr) . "\n";
    }
}
