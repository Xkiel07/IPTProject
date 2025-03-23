#!/bin/bash

# Install PHP and required extensions
sudo apt-get update
sudo apt-get install -y php8.2 php8.2-cli php8.2-mysql php8.2-zip php8.2-mbstring php8.2-xml php8.2-gd

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Laravel dependencies
composer install --optimize-autoloader --no-dev

# Install npm dependencies (optional, for front-end assets)
npm install

# Build assets (optional, for front-end assets)
npm run build

# Start the Laravel development server
php artisan serve --host=0.0.0.0 --port=10000
