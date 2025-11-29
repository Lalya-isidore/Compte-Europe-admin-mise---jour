<?php

// Usage: php scripts/check_email_translations.php

function find_email_keys_in_templates(string $dir): array {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    $keys = [];
    $pattern = '/__\(\s*[\"\']emails\.([a-zA-Z0-9_\-]+)[\"\']\s*([,)])/';
    $pattern2 = '/@lang\(\s*[\"\']emails\.([a-zA-Z0-9_\-]+)[\"\']\s*\)/';

    foreach ($files as $file) {
        if ($file->isFile() && preg_match('/\.blade\.php$/', $file->getFilename())) {
            $content = file_get_contents($file->getPathname());
            if (preg_match_all($pattern, $content, $m1)) {
                foreach ($m1[1] as $k) $keys[$k] = true;
            }
            if (preg_match_all($pattern2, $content, $m2)) {
                foreach ($m2[1] as $k) $keys[$k] = true;
            }
            // also handle trans('emails.key') or __('emails.key', ...)
            if (preg_match_all('/trans\(\s*["\']emails\.([a-zA-Z0-9_\-]+)["\']\s*\)/', $content, $m3)) {
                foreach ($m3[1] as $k) $keys[$k] = true;
            }
        }
    }
    return array_keys($keys);
}

function list_locales(string $dir): array {
    $items = [];
    $d = new DirectoryIterator($dir);
    foreach ($d as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {
            $items[] = $fileinfo->getFilename();
        }
    }
    sort($items);
    return $items;
}

function load_emails_php(string $path) {
    try {
        if (!file_exists($path)) return null;
        $arr = include $path;
        if (is_array($arr)) return $arr;
        return null;
    } catch (Throwable $e) {
        return null;
    }
}

$base = __DIR__ . '/../';
$templatesDir = $base . 'resources/views/emails';
$langDir = $base . 'resources/lang';

if (!is_dir($templatesDir)) {
    echo "Templates directory not found: $templatesDir\n";
    exit(2);
}

$keys = find_email_keys_in_templates($templatesDir);
sort($keys);

echo "Found " . count($keys) . " unique email translation keys:\n";
foreach ($keys as $k) echo " - $k\n";
echo "\n";

if (!is_dir($langDir)) {
    echo "Lang directory not found: $langDir\n";
    exit(2);
}

$locales = list_locales($langDir);

$report = [];
$localesWithEmails = 0;
foreach ($locales as $locale) {
    $emailsPath = $langDir . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . 'emails.php';
    if (!file_exists($emailsPath)) {
        $report[$locale] = [
            'status' => 'missing_file',
            'missing_keys' => $keys,
        ];
        continue;
    }
    $localArr = load_emails_php($emailsPath);
    if (!is_array($localArr)) {
        $report[$locale] = [
            'status' => 'invalid_file',
            'missing_keys' => $keys,
        ];
        continue;
    }
    $localKeys = array_keys($localArr);
    $missing = array_values(array_diff($keys, $localKeys));
    $report[$locale] = [
        'status' => (count($missing) === 0) ? 'ok' : 'missing_keys',
        'missing_keys' => $missing,
    ];
    $localesWithEmails++;
}

// Print summary
$totalLocales = count($locales);
$localesOk = 0;
$localesMissingFile = 0;
$localesMissingKeys = 0;

foreach ($report as $loc => $r) {
    if ($r['status'] === 'ok') $localesOk++;
    elseif ($r['status'] === 'missing_file') $localesMissingFile++;
    elseif ($r['status'] === 'missing_keys') $localesMissingKeys++;
}

echo "Locales scanned: $totalLocales\n";
echo "Locales with emails.php file present: $localesWithEmails\n";
echo "Locales fully OK (all keys present): $localesOk\n";
echo "Locales with missing emails.php file: $localesMissingFile\n";
echo "Locales with missing keys: $localesMissingKeys\n\n";

// Detailed listing for locales with issues
foreach ($report as $loc => $r) {
    if ($r['status'] === 'ok') continue;
    echo "Locale: $loc -> status: " . $r['status'] . "\n";
    if (!empty($r['missing_keys'])) {
        echo "  Missing keys (" . count($r['missing_keys']) . "):\n";
        foreach ($r['missing_keys'] as $mk) echo "    - $mk\n";
    }
    echo "\n";
}

// Exit code 0 when there are no missing keys and no missing files
if ($localesMissingFile === 0 && $localesMissingKeys === 0) {
    echo "All locales have the required keys.\n";
    exit(0);
}

exit(1);
