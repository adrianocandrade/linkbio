#!/bin/bash

# Define PHP binary
PHP_BIN="/usr/bin/php82"

# Check if composer exists
if ! command -v composer &> /dev/null; then
    COMPOSER_BIN="$(which composer)"
    if [ -z "$COMPOSER_BIN" ]; then
        echo "Composer not found. Trying to download..."
        # Optional: download composer if not found, but likely it is there.
        # Fallback to just 'composer' if which fails or assume it's in path
        COMPOSER_BIN="composer"
    fi
else
    COMPOSER_BIN="composer"
fi

echo "Using PHP: $PHP_BIN"
echo "Using Composer: $COMPOSER_BIN"

# 1. Pull latest changes
echo "---------------------------------"
echo "1. Pulling latest changes..."
git pull origin main

# 2. Install dependencies
echo "---------------------------------"
echo "2. Installing dependencies..."
$PHP_BIN $COMPOSER_BIN install --no-dev --optimize-autoloader

# 3. Dump Autoload (Fixes class not found issues)
echo "---------------------------------"
echo "3. Regenerating autoloader..."
$PHP_BIN $COMPOSER_BIN dump-autoload

# 4. Run Migrations
echo "---------------------------------"
echo "4. Running migrations..."
$PHP_BIN artisan migrate --force

# 5. Run Blog Seeder (Quoted to prevent shell issues)
echo "---------------------------------"
echo "5. Seeding Blog Content..."
$PHP_BIN artisan db:seed --class="Database\Seeders\BlogTableSeeder" --force

# 6. Clear Caches
echo "---------------------------------"
echo "6. Clearing caches..."
$PHP_BIN artisan cache:clear
$PHP_BIN artisan config:clear
$PHP_BIN artisan route:clear
$PHP_BIN artisan view:clear

echo "---------------------------------"
echo "Update Summary:"
echo "- Code updated"
echo "- Dependencies installed"
echo "- Database migrated"
echo "- Blog content seeded"
echo "- Caches cleared"
echo "Done!"
