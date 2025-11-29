<?php

// Usage: php scripts/fill_email_placeholders.php
// This script copies missing keys from resources/lang/fr/emails.php into each locale's emails.php
// Assumption: use French (`fr`) as the source of truth for placeholders.

$base = __DIR__ . '/../';
$langDir = $base . 'resources/lang';
$sourceLocale = 'fr';
$sourcePath = $langDir . '/' . $sourceLocale . '/emails.php';

if (!file_exists($sourcePath)) {
    echo "Source file not found: $sourcePath\n";
    exit(2);
}

$source = include $sourcePath;
if (!is_array($source)) {
    echo "Source file $sourcePath does not return an array.\n";
    exit(2);
}

$di = new DirectoryIterator($langDir);
$updated = 0;
$created = 0;
$skipped = 0;

foreach ($di as $entry) {
    if (!$entry->isDir() || $entry->isDot()) continue;
    $locale = $entry->getFilename();
    if ($locale === $sourceLocale) continue; // skip source
    if ($locale === 'locales') {
        // skip non-locale folder
        echo "Skipping folder 'locales'\n";
        continue;
    }

    $path = $langDir . '/' . $locale . '/emails.php';

    $existing = null;
    if (file_exists($path)) {
        try {
            $existing = include $path;
        } catch (Throwable $e) {
            $existing = null;
        }
    }

    if (!is_array($existing)) {
        // create new file with full copy
        $newArr = $source;
        $dir = dirname($path);
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        $content = '<?php\n\nreturn ' . var_export($newArr, true) . ";\n";
        file_put_contents($path, $content);
        echo "Created emails.php for locale: $locale\n";
        $created++;
        continue;
    }

    // merge missing keys
    $missing = array_diff_key($source, $existing);
    if (count($missing) === 0) {
        $skipped++;
        continue;
    }

    $merged = $existing + $missing; // keep existing translations, append missing (from fr)

    // write back
    $content = '<?php\n\nreturn ' . var_export($merged, true) . ";\n";
    file_put_contents($path, $content);
    echo "Updated emails.php for locale: $locale (added " . count($missing) . " keys)\n";
    $updated++;
}

echo "\nDone. Updated: $updated, Created: $created, Skipped (already complete): $skipped\n";

exit(0);
