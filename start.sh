#!/bin/bash
# Replace ${PORT} in the Nginx configuration with the value from the environment variable
sed -i "s/\${PORT}/$PORT/g" /etc/nginx/nginx.conf

# Start Nginx
nginx -g "daemon off;"
