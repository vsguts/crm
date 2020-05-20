#!/bin/sh

echo "===================================== Run nginx ====================================="

export DOLLAR='$'

# Defaults
export NGINX_PORT=${NGINX_PORT-80}
export VIRTUAL_HOST=${VIRTUAL_HOST-localhost}
export FASTCGI_HOST=${FASTCGI_HOST-php}
export FASTCGI_PORT=${FASTCGI_PORT-9000}

# Put template
envsubst < /app/docker/configs/nginx.conf.template > /etc/nginx/nginx.conf # /etc/nginx/conf.d/default.conf

# Show config: Debug
cat /etc/nginx/nginx.conf;

# Start nginx
nginx -g "daemon off;"
