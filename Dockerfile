# Use the base image
FROM richarvey/nginx-php-fpm:1.7.2

# Set environment variables (optional)
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy composer.json and composer.lock (if available)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy the rest of the application files
COPY . .

# Expose port 80 (default for HTTP)
EXPOSE 80

# Start the PHP-FPM and Nginx services
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
