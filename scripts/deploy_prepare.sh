#!/usr/bin/env bash
# scripts/deploy_prepare.sh
# Usage: run from the project parent directory or project root.
# This script attempts to:
# - locate the Laravel project (folder containing artisan)
# - create the public storage link via artisan or ln -s as fallback
# - set safe permissions for storage and public/storage
# - clear Laravel caches
# - list a few checks for images

set -euo pipefail

ROOT_CANDIDATES=("$(pwd)" "$(pwd)/public_html" "$(pwd)/public" "$(pwd)/../public_html")
PROJECT_DIR=""
for d in "${ROOT_CANDIDATES[@]}"; do
  if [ -f "$d/artisan" ]; then
    PROJECT_DIR="$d"
    break
  fi
done

if [ -z "$PROJECT_DIR" ]; then
  echo "Could not find artisan in common locations. Please run this script from the project root (where artisan lives) or ensure artisan exists." >&2
  exit 1
fi

cd "$PROJECT_DIR"
echo "Project directory: $PROJECT_DIR"

# find php binary
PHP_BIN="$(which php || true)"
if [ -z "$PHP_BIN" ]; then
  echo "php not found in PATH. Provide full path to php as first argument. Example: /usr/bin/php scripts/deploy_prepare.sh" >&2
  exit 1
fi

# Try artisan storage:link
echo "Attempting: $PHP_BIN artisan storage:link"
if $PHP_BIN artisan storage:link 2>/dev/null; then
  echo "artisan storage:link succeeded"
else
  echo "artisan storage:link failed or not permitted, trying ln -s fallback..."
  STORAGE_SRC="$PROJECT_DIR/storage/app/public"
  # determine public dir (where artisan is usually in project root; web root may be public or public_html)
  if [ -d "$PROJECT_DIR/public" ]; then
    WEB_PUBLIC="$PROJECT_DIR/public"
  elif [ -d "$PROJECT_DIR/public_html" ]; then
    WEB_PUBLIC="$PROJECT_DIR/public_html"
  else
    # fallback to project_dir
    WEB_PUBLIC="$PROJECT_DIR"
  fi
  TARGET_LINK="$WEB_PUBLIC/storage"

  if [ -e "$TARGET_LINK" ]; then
    echo "Target link $TARGET_LINK already exists (file/dir). Skipping ln -s creation." 
  else
    echo "Creating symlink: ln -s $STORAGE_SRC $TARGET_LINK"
    ln -s "$STORAGE_SRC" "$TARGET_LINK"
    echo "Symlink created: $TARGET_LINK -> $STORAGE_SRC"
  fi
fi

# Permissions: attempt to set conservative permissions
echo "Setting permissions on storage and public/storage"
if id -u www-data >/dev/null 2>&1; then
  WEBUSER=www-data
elif id -u www >/dev/null 2>&1; then
  WEBUSER=www
else
  WEBUSER=""
fi

if [ -n "$WEBUSER" ]; then
  echo "Detected web user: $WEBUSER - attempting chown (may require sudo)"
  if sudo -n true 2>/dev/null; then
    sudo chown -R "$WEBUSER":"$WEBUSER" storage "$WEB_PUBLIC/storage" || true
  else
    echo "No passwordless sudo, skipping chown. If images show 403 you may need to adjust ownership manually."
  fi
fi

find storage -type d -exec chmod 2755 {} \;
find storage -type f -exec chmod 0644 {} \;
if [ -d "$WEB_PUBLIC/storage" ]; then
  find "$WEB_PUBLIC/storage" -type d -exec chmod 2755 {} \;
  find "$WEB_PUBLIC/storage" -type f -exec chmod 0644 {} \;
fi

# Clear Laravel caches
echo "Clearing Laravel caches"
$PHP_BIN artisan config:clear || true
$PHP_BIN artisan cache:clear || true
$PHP_BIN artisan route:clear || true
$PHP_BIN artisan view:clear || true

# Optional: recreate config cache (safe to skip if you want dynamic env during deploy)
$PHP_BIN artisan config:cache || true

# Quick checks
echo "Quick checks: listing a few files in storage/app/public/comptes-photos"
ls -la storage/app/public/comptes-photos | sed -n '1,20p' || true

# Test if a sample file is readable via the filesystem
SAMPLE_FILE=$(ls storage/app/public/comptes-photos | head -n1 || true)
if [ -n "$SAMPLE_FILE" ]; then
  if [ -f "storage/app/public/comptes-photos/$SAMPLE_FILE" ]; then
    echo "Sample file exists: storage/app/public/comptes-photos/$SAMPLE_FILE"
  fi
fi

echo "Deploy preparation complete. If images still don't appear, check webserver config, permissions, and that image URLs use /storage/... path."
# Ensure a public copy exists for environments that block symlinks (hosted/shared)
if [ -d "storage/app/public" ]; then
  echo "Syncing storage/app/public to public_html/storage_public (if public_html exists)"
  if [ -d "$PROJECT_DIR/public_html" ]; then
    rsync -av --delete "$PROJECT_DIR/storage/app/public/" "$PROJECT_DIR/public_html/storage_public/" || true
  elif [ -d "$PROJECT_DIR/public" ]; then
    rsync -av --delete "$PROJECT_DIR/storage/app/public/" "$PROJECT_DIR/public/storage_public/" || true
  fi
fi

echo "If you prefer to serve files via a /storage alias, update your web server or .htaccess accordingly."
exit 0
