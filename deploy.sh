#!/usr/bin/env bash

echo "Running composer..."
composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "Deployment script completed."
