FROM richarvey/nginx-php-fpm:1.7.2

# Set the working directory
WORKDIR /var/www/html

# Print the working directory
RUN pwd

# List files in the working directory
RUN ls -la

# Copy composer.json and composer.lock
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy the rest of the application files
COPY . .

# Expose port 80
EXPOSE 80

# Start services
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
