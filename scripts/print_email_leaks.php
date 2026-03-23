<?php
// Usage: php scripts/print_email_leaks.php
$path = __DIR__ . '/email_fr_leak_report.json';
if (!file_exists($path)) { fwrite(STDERR, "Report not found: $path\n"); exit(1); }
$r = json_decode(file_get_contents($path), true);
if (!isset($r['locales'])) { fwrite(STDERR, "Invalid report format\n"); exit(1); }
$full = [];
$partial = [];
foreach ($r['locales'] as $loc => $v) {
    $tk = $v['total_keys'] ?? 0;
    $ic = $v['identical_count'] ?? 0;
    if ($tk > 0 && $ic === $tk) $full[] = "$loc: $ic/$tk";
    elseif ($ic > 0) $partial[] = "$loc: $ic/$tk";
}
echo "---FULL IDENTICAL (values identical to FR)---\n";
if (empty($full)) echo "(aucune)\n"; else echo implode("\n", $full) . "\n";
echo "\n---PARTIAL IDENTICAL (some values identical)---\n";
if (empty($partial)) echo "(aucune)\n"; else echo implode("\n", $partial) . "\n";

// Print counts
$all = count($r['locales']);
echo "\nSummary: locales={$all}, full_identical=" . count($full) . ", partial_identical=" . count($partial) . "\n";
