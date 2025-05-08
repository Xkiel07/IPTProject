#!/bin/bash

# Wait for PostgreSQL to be ready
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
  echo "Waiting for PostgreSQL..."
  sleep 2
done

# Run Laravel post-setup commands
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan optimize

# Start Apache server
exec apache2-foreground
