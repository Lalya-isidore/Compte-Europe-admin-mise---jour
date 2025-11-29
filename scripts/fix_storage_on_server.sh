#!/usr/bin/env bash
set -euo pipefail

# Usage: ./scripts/fix_storage_on_server.sh [PROJECT_ROOT]
# Default PROJECT_ROOT: /home/u169579688/domains/easytransferflux.world

PROJECT_ROOT=${1:-/home/u169579688/domains/easytransferflux.world}
echo "Project root: $PROJECT_ROOT"

cd "$PROJECT_ROOT" || { echo "Cannot cd to $PROJECT_ROOT"; exit 2; }

echo "Creating missing target directories (storage/app/public/...)"
mkdir -p storage/app/public/comptes-photos
mkdir -p storage/app/public/support/attachments

# Helper to move files if present
move_if_any() {
  local src_dir="$1"
  local dst_dir="$2"
  if [ -d "$src_dir" ]; then
    shopt -s nullglob
    files=("$src_dir"/*)
    if [ ${#files[@]} -gt 0 ]; then
      echo "Moving files from $src_dir to $dst_dir"
      mv "$src_dir"/* "$dst_dir" || true
    else
      echo "No files to move in $src_dir"
    fi
    shopt -u nullglob
  else
    echo "Source directory $src_dir does not exist — skipping"
  fi
}

move_if_any "public_html/storage_public/comptes-photos" "storage/app/public/comptes-photos"
move_if_any "public_html/storage_public/support/attachments" "storage/app/public/support/attachments"

if [ -d "public_html/storage_public" ]; then
  echo "Removing old fallback directory public_html/storage_public"
  rm -rf public_html/storage_public || true
else
  echo "public_html/storage_public not present — nothing to remove"
fi

echo "Recreating correct storage symlink"
# Remove existing (file/dir/symlink)
if [ -L "public_html/storage" ] || [ -e "public_html/storage" ]; then
  echo "Removing existing public_html/storage"
  rm -rf public_html/storage || true
fi

TARGET="$PROJECT_ROOT/storage/app/public"
LINK="$PROJECT_ROOT/public_html/storage"
echo "Creating symlink: ln -s $TARGET $LINK"
ln -s "$TARGET" "$LINK"

echo "Listing account photos in storage/app/public/comptes-photos"
ls -la storage/app/public/comptes-photos || true

echo "Verifying the public storage link"
ls -la public_html/storage || true

echo "Done. If images still do not appear, check webserver permissions and .htaccess rules."
