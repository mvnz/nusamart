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
echo "[5/8] Running database migrations..."
php "$APP_DIR/artisan" migrate --force
echo "      Done."

# 5b. Reassign produk ke SELLER_EMAIL (jika diset di .env)
SELLER_EMAIL=$(grep -E '^SELLER_EMAIL=' "$APP_DIR/.env" | cut -d '=' -f2 | tr -d ' \r')
if [ -n "$SELLER_EMAIL" ] && [ "$SELLER_EMAIL" != "penjual@nusamart.com" ]; then
    DB_HOST=$(grep -E '^ *DB_HOST=' "$APP_DIR/.env" | cut -d '=' -f2 | tr -d ' \r')
    DB_PORT=$(grep -E '^ *DB_PORT=' "$APP_DIR/.env" | cut -d '=' -f2 | tr -d ' \r')
    DB_DATABASE=$(grep -E '^ *DB_DATABASE=' "$APP_DIR/.env" | cut -d '=' -f2 | tr -d ' \r')
    DB_USERNAME=$(grep -E '^ *DB_USERNAME=' "$APP_DIR/.env" | cut -d '=' -f2 | tr -d ' \r')
    DB_PASSWORD=$(grep -E '^ *DB_PASSWORD=' "$APP_DIR/.env" | cut -d '=' -f2 | tr -d ' \r')
    echo "[5b] Reassigning products to $SELLER_EMAIL ..."
    mysql -h "${DB_HOST:-127.0.0.1}" -P "${DB_PORT:-3306}" -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" <<SQL
UPDATE products p
JOIN users u ON u.email = '$SELLER_EMAIL'
JOIN users old ON old.email = 'penjual@nusamart.com'
SET p.user_id = u.id
WHERE p.user_id = old.id;
SQL
    echo "      Done."
fi

# 6. Generate index.php di webroot (public_html/index.php → nusamart app)
echo "[6/8] Writing index.php at webroot..."
cat > "$PUBLIC_HTML/index.php" <<'PHP'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/nusamart/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/nusamart/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/nusamart/bootstrap/app.php';

$app->handleRequest(Request::capture());
PHP
echo "      Done."

# 7. Storage symlink di webroot (public_html/storage → nusamart/storage/app/public)
echo "[7/8] Creating storage symlink at webroot..."
# Remove existing dir/symlink first — ln -sfn won't replace a real directory
rm -rf "$PUBLIC_HTML/storage"
ln -s "$APP_DIR/storage/app/public" "$PUBLIC_HTML/storage"
echo "      Done. ($PUBLIC_HTML/storage -> $APP_DIR/storage/app/public)"

# 8. Clear semua cache Laravel
echo "[8/8] Clearing caches..."
php "$APP_DIR/artisan" config:clear
php "$APP_DIR/artisan" cache:clear
php "$APP_DIR/artisan" view:clear
php "$APP_DIR/artisan" route:clear
echo "      Done."

echo ""
echo "======================================"
echo "  Deploy selesai!"
echo "======================================"
