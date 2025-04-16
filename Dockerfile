FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl git libpng-dev libjpeg-dev \
    libfreetype6-dev libonig-dev libgd-dev libpq-dev \
    nodejs npm && \
    rm -rf /var/lib/apt/lists/*

# Configure Apache and PHP
RUN a2enmod rewrite headers
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql pdo_pgsql zip mbstring bcmath gd

# Set Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Add static files configuration
RUN { \
    echo '<Directory /var/www/html/public>'; \
    echo '    Options FollowSymLinks'; \
    echo '    AllowOverride All'; \
    echo '    Require all granted'; \
    echo '    <FilesMatch "\.(css|js|jpg|png|gif|ico|svg|woff2)$">'; \
    echo '        Header set Cache-Control "max-age=31536000, public"'; \
    echo '    </FilesMatch>'; \
    echo '</Directory>'; \
} > /etc/apache2/conf-available/laravel.conf && \
    a2enconf laravel

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application
COPY . /var/www/html/
WORKDIR /var/www/html

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs

# Install Node dependencies and build assets
RUN npm install --no-audit --prefer-offline && \
    npm run build && \
    rm -rf node_modules && \
    npm cache clean --force

# Setup storage
RUN mkdir -p /var/www/html/storage/framework/{cache,sessions,views} && \
    mkdir -p /var/www/html/storage/logs

# Set permissions
RUN chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \; && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Laravel optimization
RUN php artisan storage:link && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 80

# Start command
CMD ["apache2-foreground"]
