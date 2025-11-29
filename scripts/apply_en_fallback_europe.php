<?php
// Usage: php apply_en_fallback_europe.php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$base = realpath(__DIR__ . '/../resources/lang');
if (!$base) { echo "Lang folder not found\n"; exit(1); }

// EU language codes (ISO-639 or common locale codes present in repo)
$europeCodes = [
    'bg','hr','cs','da','de','ee','el','es','fi','fr','hu','ie','it','lt','lv','lu','mt','nl','pl','pt','ro','sk','sl','sv','cy','is','no','ba','be','al','at','ch'
];

$frFile = $base . '/fr/emails.php';
$enFile = $base . '/en/emails.php';
if (!file_exists($frFile) || !file_exists($enFile)) { echo "Missing fr or en emails.php\n"; exit(1); }
$fr = include $frFile;
$en = include $enFile;
if (!is_array($fr) || !is_array($en)) { echo "fr or en files do not return arrays\n"; exit(1); }

$backupDir = __DIR__ . '/backup_emails_before_en_fallback_' . date('Ymd_His');
if (!mkdir($backupDir, 0755, true)) { echo "Cannot create backup dir $backupDir\n"; exit(1); }

$modifiedFiles = [];
$localeDirs = glob($base . '/*', GLOB_ONLYDIR);
foreach ($localeDirs as $dir) {
    $locale = basename($dir);
    if ($locale === 'fr' || $locale === 'en') continue;
    if (!in_array($locale, $europeCodes)) continue; // only apply to our europe list

    $f = $dir . '/emails.php';
    if (!file_exists($f)) continue;
    $data = include $f;
    if (!is_array($data)) continue;

    $orig = $data;
    $changed = false;

    foreach ($fr as $key => $frVal) {
        if (!array_key_exists($key, $data)) continue;
        $cur = $data[$key];
        if ($cur === $frVal) {
            if (array_key_exists($key, $en) && $en[$key] !== $frVal) {
                $data[$key] = $en[$key];
                $changed = true;
            }
        }
    }

    if ($changed) {
        // backup
        $bkPath = $backupDir . '/resources/lang/' . $locale;
        @mkdir($bkPath, 0755, true);
        copy($f, $bkPath . '/emails.php');

        // write new file
        $export = var_export($data, true);
        $php = "<?php\n\nreturn " . $export . ";\n";
        file_put_contents($f, $php);
        $modifiedFiles[] = $f;
        echo "Modified: $f\n";
    } else {
        echo "No change for locale: $locale\n";
    }
}

if (empty($modifiedFiles)) {
    echo "\nNo files modified.\n";
} else {
    echo "\nModified files count: " . count($modifiedFiles) . "\n";
    echo "Backup created at: $backupDir\n";
}

// Re-run analysis
echo "\nRe-running analysis...\n";
passthru('php "' . __DIR__ . '/analyze_email_translations.php"');

echo "\nDone.\n";
