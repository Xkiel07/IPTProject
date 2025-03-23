#!/bin/bash

# Install Node.js dependencies
npm install

# Build front-end assets
npm run build

# Install PHP dependencies (if using Composer)
if [ -f "composer.json" ]; then
    # Download Composer
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

    # Install PHP dependencies
    php /usr/local/bin/composer install --optimize-autoloader --no-dev
fi

# Start the Laravel development server (optional)
# php artisan serve --host=0.0.0.0 --port=10000
