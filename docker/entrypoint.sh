#!/bin/bash

# Exit on fail
set -e

# Cache configs
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (Force because in production)
echo "Running migrations..."
php artisan migrate --force

# Start Nginx and PHP-FPM
echo "Starting services..."
# Start php-fpm in background
php-fpm -D
# Start nginx in foreground
nginx -g "daemon off;"
