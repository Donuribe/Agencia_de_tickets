#!/bin/sh
set -e

cd /var/www/html

# Crear .env con las variables de Railway
cat > .env << EOF
APP_NAME="Agencia de Tickets"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}
LOG_CHANNEL=stderr
LOG_LEVEL=error
DB_CONNECTION=${DB_CONNECTION:-mysql}
DB_HOST=${DB_HOST:-127.0.0.1}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE:-agencia_tickets}
DB_USERNAME=${DB_USERNAME:-root}
DB_PASSWORD=${DB_PASSWORD}
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
EOF

# Limpiar cachés
php artisan config:clear
php artisan cache:clear

# Migraciones
php artisan migrate --force --no-interaction

# Storage link
php artisan storage:link --force 2>/dev/null || true

# Cachear para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar PHP-FPM en background
php-fpm -D

# Iniciar Nginx en foreground
nginx -g "daemon off;"
