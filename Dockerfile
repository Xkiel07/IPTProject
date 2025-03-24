FROM richarvey/nginx-php-fpm:latest

# Copy your application files
COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Expose the port (Render will use the PORT environment variable)
EXPOSE $PORT

# Create a startup script to replace ${PORT} in the Nginx configuration
RUN echo "#!/bin/bash" > /start.sh && \
    echo "sed -i \"s/\${PORT}/$PORT/g\" /etc/nginx/sites-enabled/default.conf" >> /start.sh && \
    echo "nginx -g 'daemon off;'" >> /start.sh && \
    chmod +x /start.sh

# Run the startup script
CMD ["/start.sh"]
