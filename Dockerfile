# Use an official PHP image as the base image
FROM php:8.2-cli

# Set the working directory
WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# Install Node.js and npm (optional, for front-end assets)
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Laravel application files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Install npm dependencies (optional, for front-end assets)
RUN npm install

# Build assets (optional, for front-end assets)
RUN npm run build

# Expose port 10000
EXPOSE 10000

# Start the Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
