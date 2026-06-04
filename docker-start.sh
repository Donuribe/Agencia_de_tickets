#!/bin/bash
set -e

cd /var/www/html

# Generar APP_KEY si no existe
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Crear .env en producción con las variables de entorno
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

SESSION_DRIVER=${SESSION_DRIVER:-file}
SESSION_LIFETIME=120

CACHE_STORE=${CACHE_STORE:-file}
QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}

FILESYSTEM_DISK=local
EOF

# Limpiar y cachear configuración
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Ejecutar migraciones
php artisan migrate --force --no-interaction

# Crear symlink de storage
php artisan storage:link --force 2>/dev/null || true

# Cachear para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar Apache
apache2-foreground
