<?php
// Usage: php scripts/print_fr_leaks_summary.php
$j = json_decode(file_get_contents(__DIR__ . '/email_fr_leak_report.json'), true);
if (!$j || !isset($j['locales'])) {
    fwrite(STDERR, "Impossible de lire scripts/email_fr_leak_report.json\n");
    exit(1);
}
$locales = $j['locales'];
$with = [];
foreach ($locales as $loc => $data) {
    $count = isset($data['identical_count']) ? (int)$data['identical_count'] : 0;
    if ($count > 0) {
        $with[$loc] = $data;
    }
}
// Sort by descending identical_count
uksort($with, function($a, $b) use ($with) { return ($with[$b]['identical_count'] ?? 0) - ($with[$a]['identical_count'] ?? 0); });

echo "Locales with identical French keys (from scripts/email_fr_leak_report.json)\n";
echo "Generated: " . ($j['generated_at'] ?? 'unknown') . "\n\n";
$totalLocales = count($with);
echo "Total locales with identical keys: $totalLocales\n\n";

foreach ($with as $loc => $data) {
    $count = $data['identical_count'] ?? 0;
    echo "$loc: $count identical key(s)\n";
    // If small count, print the keys; otherwise print first 6 keys as sample
    $keys = $data['identical_keys'] ?? [];
    if ($count <= 6) {
        foreach ($keys as $k) echo "  - $k\n";
    } else {
        $sample = array_slice($keys, 0, 6);
        foreach ($sample as $k) echo "  - $k\n";
        $remaining = $count - count($sample);
        if ($remaining > 0) echo "  ... and $remaining more keys\n";
    }
    // show french_substrings if any
    if (!empty($data['french_substrings'])) {
        echo "  french_substrings: \n";
        foreach ($data['french_substrings'] as $k => $arr) {
            echo "    $k: [" . implode(', ', array_slice($arr,0,5)) . "]\n";
        }
    }
    echo "\n";
}

exit(0);
