#!/bin/bash

# Install PHP and required extensions
apt-get update
apt-get install -y php8.2 php8.2-cli php8.2-mysql php8.2-zip php8.2-mbstring php8.2-xml php8.2-gd

# Install Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
composer install --optimize-autoloader --no-dev

# Install npm dependencies
npm install

# Build assets
npm run build

# Start the Laravel development server
php artisan serve --host=0.0.0.0 --port=10000
