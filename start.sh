#!/bin/bash

# Set default port if not provided
PORT=${PORT:-8080}

# Replace ${PORT} in nginx.conf
sed -i "s/\${PORT}/$PORT/g" /etc/nginx/nginx.conf

# Start nginx in foreground
nginx -g "daemon off;"
