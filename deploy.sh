#!/bin/bash
# =============================================================
# NusaMart Deploy Script
# Jalankan dari: ~/public_html/nusamart/
# Usage: bash deploy.sh
# =============================================================

set -e

APP_DIR="$(cd "$(dirname "$0")" && pwd)"
PUBLIC_HTML="$(dirname "$APP_DIR")"

echo "======================================"
echo "  NusaMart Deploy Script"
echo "======================================"
echo "App dir   : $APP_DIR"
echo "Public HTML: $PUBLIC_HTML"
echo ""

# 1. Pull kode terbaru
echo "[1/6] Pulling latest code from git..."
git -C "$APP_DIR" pull origin main
echo "      Done."

# 2. Install/update dependencies composer
echo "[2/6] Running composer install..."
cd "$APP_DIR"
composer install --no-dev --optimize-autoloader --no-interaction
echo "      Done."

# 3. Copy static assets ke public_html root
echo "[3/6] Copying CSS assets..."
cp -f "$APP_DIR/public/css/"*.css "$PUBLIC_HTML/css/"
echo "      Copied: $(ls "$APP_DIR/public/css/"*.css | wc -l) file(s)"

echo "[4/6] Copying JS assets..."
cp -f "$APP_DIR/public/js/"*.js "$PUBLIC_HTML/js/"
echo "      Copied: $(ls "$APP_DIR/public/js/"*.js | wc -l) file(s)"

# 4. Copy favicon jika berubah
if [ -f "$APP_DIR/public/favicon.ico" ]; then
    cp -f "$APP_DIR/public/favicon.ico" "$PUBLIC_HTML/favicon.ico"
fi

# 5. Jalankan migrasi database
echo "[5/6] Running database migrations..."
php "$APP_DIR/artisan" migrate --force
echo "      Done."

# 6. Clear semua cache Laravel
echo "[6/6] Clearing caches..."
php "$APP_DIR/artisan" config:clear
php "$APP_DIR/artisan" cache:clear
php "$APP_DIR/artisan" view:clear
php "$APP_DIR/artisan" route:clear
echo "      Done."

echo ""
echo "======================================"
echo "  Deploy selesai!"
echo "======================================"
