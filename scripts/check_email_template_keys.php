<?php
// Usage: php check_email_template_keys.php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$templates = glob(__DIR__ . '/../resources/views/emails/**/*.blade.php');
if (empty($templates)) {
    $templates = glob(__DIR__ . '/../resources/views/emails/*.blade.php');
}
$frFile = __DIR__ . '/../resources/lang/fr/emails.php';
if (!file_exists($frFile)) {
    echo "Fichier FR introuvable: $frFile\n";
    exit(1);
}
$fr = include $frFile;
if (!is_array($fr)) {
    echo "Le fichier FR ne retourne pas un tableau.\n";
    exit(1);
}
$frKeys = array_keys($fr);

$pattern = '/__\(\s*["\']emails\.([a-zA-Z0-9_]+)["\']/';
$pattern2 = '/@lang\(\s*["\']emails\.([a-zA-Z0-9_]+)["\']/';
$pattern3 = '/trans\(\s*["\']emails\.([a-zA-Z0-9_]+)["\']/';

$report = [];
foreach ($templates as $tpl) {
    $content = file_get_contents($tpl);
    $keys = [];
    if (preg_match_all($pattern, $content, $m)) {
        $keys = array_merge($keys, $m[1]);
    }
    if (preg_match_all($pattern2, $content, $m2)) {
        $keys = array_merge($keys, $m2[1]);
    }
    if (preg_match_all($pattern3, $content, $m3)) {
        $keys = array_merge($keys, $m3[1]);
    }
    // also capture __('emails.some.key', ... ) with dot notation beyond single segment
    if (preg_match_all('/__\(\s*["\'](emails\.[a-zA-Z0-9_.-]+)["\']/', $content, $m4)) {
        foreach ($m4[1] as $full) {
            $seg = explode('.', $full);
            if (isset($seg[1])) $keys[] = $seg[1];
        }
    }

    $keys = array_values(array_unique($keys));
    $missing = [];
    foreach ($keys as $k) {
        if (!in_array($k, $frKeys)) $missing[] = $k;
    }
    $report[$tpl] = [
        'keys_used' => $keys,
        'missing_in_fr' => $missing,
        'count_used' => count($keys),
        'count_missing' => count($missing)
    ];
}

// Print concise summary
echo "Template | keys_used | missing_count\n";
foreach ($report as $tpl => $r) {
    $short = str_replace(getcwd() . DIRECTORY_SEPARATOR, '', $tpl);
    printf("%s | %d | %d\n", $short, $r['count_used'], $r['count_missing']);
}

// Print details for templates with missing keys
$any = false;
foreach ($report as $tpl => $r) {
    if ($r['count_missing'] > 0) {
        $any = true;
        echo "\n-- Missing keys in: $tpl \n";
        foreach ($r['missing_in_fr'] as $k) echo "  - $k\n";
    }
}
if (!$any) echo "\nAucun key manquant détecté dans les templates (tout référencé dans fr/emails.php).\n";

// Save detailed JSON report
file_put_contents(__DIR__ . '/email_template_keys_report.json', json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "\nDétail écrit dans scripts/email_template_keys_report.json\n";
