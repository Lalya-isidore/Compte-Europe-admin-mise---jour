#!/bin/bash
# scripts/clear_cache.sh
# Usage: run this from the project root or execute the script directly.

set -euo pipefail

# Resolve project root (script is in scripts/)
ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT_DIR"

if [ ! -f artisan ]; then
  echo "artisan not found in $ROOT_DIR. Run this from the project root or place the script next to artisan."
  exit 1
fi

PHP_BIN="$(which php || true)"
if [ -z "$PHP_BIN" ]; then
  echo "php not found in PATH. Please use full path to php (ex: /usr/bin/php) or install php-cli." >&2
  exit 1
fi

echo "Using php: $PHP_BIN"

# Clear caches
$PHP_BIN artisan config:clear
$PHP_BIN artisan cache:clear
$PHP_BIN artisan route:clear
$PHP_BIN artisan view:clear

# Recreate config cache (optional) - ignore errors
$PHP_BIN artisan config:cache || true

echo "Laravel caches cleared. If you're on a shared host and cannot run artisan, see scripts/clear_cache.ps1 or ask your host to run these commands."