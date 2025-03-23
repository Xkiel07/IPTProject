#!/bin/bash
# Start NGINX
service nginx start
# Start PHP-FPM
service php-fpm start
# Keep the container running
tail -f /dev/null
