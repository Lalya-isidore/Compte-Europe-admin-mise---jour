<?php
$report = json_decode(file_get_contents(__DIR__ . '/email_fr_leak_report.json'), true);
$locales = [];
foreach ($report['locales'] as $locale => $data) {
    if (isset($data['identical_count']) && isset($data['total_keys']) && $data['identical_count'] === $data['total_keys']) {
        $locales[] = $locale;
    }
}
if (empty($locales)) {
    echo "(none)\n";
    exit(0);
}
echo implode("\n", $locales) . "\n";
