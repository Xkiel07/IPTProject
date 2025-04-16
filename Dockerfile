FROM php:8.2-apache

# Install dependencies
RUN apt-get update && \
    apt-get install -y libzip-dev zip unzip curl git

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip

# Set the Laravel public directory as the Apache root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy only composer files first (for Docker cache)
COPY composer.json composer.lock /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Install Laravel dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Copy the rest of the code after dependencies are installed
COPY . /var/www/html

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
