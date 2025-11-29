<?php
// scripts/normalize_refund_headings.php
// Scans resources/lang/*/emails.php and normalizes 'refund_heading' values
// by keeping only the part before the first ' / '. Creates a .bak backup for each file.

$base = __DIR__ . '/../resources/lang';
$dirs = glob($base . '/*', GLOB_ONLYDIR);
$modified = [];

foreach ($dirs as $dir) {
    $file = $dir . '/emails.php';
    if (!file_exists($file)) continue;
    $contents = file_get_contents($file);
    // Match pattern: 'refund_heading' => '... / ...'
    $pattern = "/'refund_heading'\s*=>\s*'([^']*?)\\s*\\/\\s*([^']*?)'/i";
    // Use callback to preserve left side (before the slash)
    $new = preg_replace_callback("/'refund_heading'\s*=>\s*'([^']*?)\\s*\\/\\s*([^']*?)'/i", function ($m) {
        $left = trim($m[1]);
        // escape single quotes if any
        $left = str_replace("'", "\\'", $left);
        return "'refund_heading' => '" . $left . "'";
    }, $contents, 1);

    if ($new !== null && $new !== $contents) {
        // backup
        copy($file, $file . '.bak');
        file_put_contents($file, $new);
        $modified[] = $file;
    }
}

echo "Modified files:\n";
foreach ($modified as $f) echo " - $f\n";
if (empty($modified)) echo "(none)\n";
