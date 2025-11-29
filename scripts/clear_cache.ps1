# scripts/clear_cache.ps1
# Usage: run from the project root in PowerShell (Windows) or on a server with PowerShell installed.

param()

$here = Split-Path -Parent $MyInvocation.MyCommand.Definition
$root = Resolve-Path "$here\.."
Set-Location $root.Path

if (-not (Test-Path -Path "artisan" -PathType Leaf)) {
    Write-Error "artisan not found in $($root.Path). Run this script from the project root or place it next to artisan."
    exit 1
}

$php = Get-Command php -ErrorAction SilentlyContinue
if (-not $php) {
    Write-Error "php not found in PATH. Provide full path to php or install php-cli." -ErrorAction Stop
    exit 1
}

Write-Host "Using php: $($php.Path)"
& $php.Path artisan config:clear
& $php.Path artisan cache:clear
& $php.Path artisan route:clear
& $php.Path artisan view:clear

try {
    & $php.Path artisan config:cache
} catch {
    Write-Warning "config:cache failed (non-fatal)."
}

Write-Host "Laravel caches cleared."