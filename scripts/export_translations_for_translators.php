<?php
// Exports a CSV listing translation work for translators.
// Columns: locale,key,fr_value,current_value,draft_value

$base = __DIR__ . DIRECTORY_SEPARATOR;
$frFile = realpath($base . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'fr' . DIRECTORY_SEPARATOR . 'emails.php');
if (!$frFile) {
    fwrite(STDERR, "FR source not found\n");
    exit(1);
}
$fr = include $frFile;
if (!is_array($fr)) {
    fwrite(STDERR, "FR source did not return array\n");
    exit(1);
}

$csvPath = $base . 'email_translations_for_translators_todo.csv';
$fh = fopen($csvPath, 'w');
if (!$fh) { fwrite(STDERR, "Cannot open $csvPath for writing\n"); exit(1); }
// header
fputcsv($fh, ['locale','key','fr_value','current_value','draft_value']);

// load available drafts
$pattern = $base . 'auto_translations_*.php';
$files = glob($pattern);
// also include any auto_translations that might use hyphens like zh-CN
$files = array_unique($files);

foreach ($files as $file) {
    $filename = basename($file);
    // extract locale
    $m = [];
    if (!preg_match('#^auto_translations_(.+)\\.php$#', $filename, $m)) continue;
    $locale = $m[1];
    $locale = str_replace('-', '/', $locale); // reverse earlier safe transform if any
    // include draft
    $draft = include $file;
    if (!is_array($draft)) continue;
    // load current locale file if exists
    $localePath = realpath($base . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . 'emails.php');
    $current = [];
    if ($localePath && file_exists($localePath)) {
        $cur = include $localePath;
        if (is_array($cur)) $current = $cur;
    }
    foreach ($draft as $key => $draftVal) {
        $frVal = array_key_exists($key, $fr) ? $fr[$key] : '';
        $currentVal = array_key_exists($key, $current) ? $current[$key] : '';
        fputcsv($fh, [$locale, $key, $frVal, $currentVal, $draftVal]);
    }
}

// Also include any remaining locales that have identical keys but for which we may not have generated a draft file
// We'll read the audit to find locales with identical_count > 0 and no draft, and add rows for those keys (current_value may equal FR)
$report = json_decode(file_get_contents($base . 'email_fr_leak_report.json'), true);
if (is_array($report) && isset($report['locales'])) {
    foreach ($report['locales'] as $locale => $data) {
        // skip locales we already processed via drafts
        $safe = str_replace('/', '-', $locale);
        $draftFile = $base . "auto_translations_{$safe}.php";
        if (file_exists($draftFile)) continue;
        if (!isset($data['identical_count']) || $data['identical_count'] === 0) continue;
        if (empty($data['identical_keys'])) continue;
        // load current locale file if exists
        $localePath = realpath($base . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . 'emails.php');
        $current = [];
        if ($localePath && file_exists($localePath)) {
            $cur = include $localePath;
            if (is_array($cur)) $current = $cur;
        }
        foreach ($data['identical_keys'] as $key) {
            $frVal = array_key_exists($key, $fr) ? $fr[$key] : '';
            $currentVal = array_key_exists($key, $current) ? $current[$key] : '';
            // mark draft_value empty to signal translator needs to provide
            fputcsv($fh, [$locale, $key, $frVal, $currentVal, '']);
        }
    }
}

fclose($fh);
echo "Wrote $csvPath\n";
