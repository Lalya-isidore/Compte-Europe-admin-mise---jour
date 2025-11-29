<?php
// Usage: php scripts/apply_auto_translations.php
$base = __DIR__ . '/../resources/lang';
$backdir = __DIR__ . '/backups';
if (!is_dir($backdir)) mkdir($backdir, 0755, true);

// Discover all draft files named auto_translations_<locale>.php
$autoFiles = glob(__DIR__ . '/auto_translations_*.php');
foreach ($autoFiles as $autoFile) {
    $bn = basename($autoFile); // auto_translations_vi.php
    // Extract locale between prefix and .php
    $loc = preg_replace('#^auto_translations_(.+)\.php$#', '$1', $bn);
    $target = $base . '/' . $loc . '/emails.php';
    if (!file_exists($target)) {
        echo "skip($loc): target not found\n";
        continue;
    }

    // create backup if missing
    $backup = $backdir . '/resources_lang_' . $loc . '_emails.php.bak';
    if (!file_exists($backup)) {
        $arr = include $target;
        if (!is_array($arr)) {
            echo "backup_skip($loc): target did not return array\n";
        } else {
            $out = "<?php\n\n// Backup of {$target}\n\nreturn " . var_export($arr, true) . ";\n";
            file_put_contents($backup, $out);
            echo "backup_created: $backup\n";
        }
    } else {
        echo "backup_exists: $backup\n";
    }

    $auto = __DIR__ . '/auto_translations_' . $loc . '.php';
    if (!file_exists($auto)) {
        echo "no_draft: $loc\n";
        continue;
    }
    $draft = include $auto;
    if (!is_array($draft)) {
        echo "draft_invalid: $loc\n";
        continue;
    }

    $arr = include $target;
    if (!is_array($arr)) {
        echo "target_invalid: $loc\n";
        continue;
    }

    $changed = false;
    foreach ($draft as $k => $v) {
        // If key missing or value differs from desired draft, set it.
        if (!array_key_exists($k, $arr) || $arr[$k] !== $v) {
            $arr[$k] = $v;
            $changed = true;
        }
    }

    if ($changed) {
        // Export array back to PHP file
        $export = var_export($arr, true);
        // Make output look like original style
        $out = "<?php\n\nreturn " . $export . ";\n";
        file_put_contents($target, $out);
        echo "updated: $target\n";
    } else {
        echo "no_change: $loc\n";
    }
}
