FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl git libpng-dev libjpeg-dev \
    libfreetype6-dev libonig-dev libgd-dev libpq-dev \
    nodejs npm && \
    rm -rf /var/lib/apt/lists/*

# Configure Apache and PHP
RUN a2enmod rewrite headers && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_mysql pdo_pgsql zip mbstring bcmath gd

# Set Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Add MIME types for fonts
RUN echo "\n\
AddType application/font-woff2 .woff2\n\
AddType application/font-woff .woff\n\
AddType application/vnd.ms-fontobject .eot\n\
AddType application/x-font-ttf .ttf\n\
" >> /etc/apache2/mods-available/mime.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application
COPY . /var/www/html/
WORKDIR /var/www/html

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs

# Install and configure Font Awesome
RUN npm install @fortawesome/fontawesome-free --no-audit --prefer-offline && \
    mkdir -p public/fonts && \
    cp -r node_modules/@fortawesome/fontawesome-free/webfonts/* public/fonts/ && \
    chmod -R 755 public/fonts && \
    rm -rf node_modules && \
    npm cache clean --force

# Setup storage directories
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs

# Set permissions
RUN chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \; && \
    chmod -R 775 storage bootstrap/cache

# Laravel optimization
RUN php artisan storage:link && \
    php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:clear && \
    php artisan route:cache && \
    php artisan view:clear && \
    php artisan view:cache

EXPOSE 80

# Health check
HEALTHCHECK --interval=30s --timeout=3s \
  CMD curl -f http://localhost/ || exit 1

# Start Apache
CMD ["apache2-foreground"]
