#!/bin/bash
set -e

cd /var/www/html

# Si Render provee DATABASE_URL (PostgreSQL), parsearlo
if [ -n "$DATABASE_URL" ]; then
    # Extraer componentes de la URL: postgres://user:pass@host:port/dbname
    DB_CONNECTION="pgsql"
    DB_HOST=$(echo $DATABASE_URL | sed -e 's|^.*@||' -e 's|:.*||' -e 's|/.*||')
    DB_PORT=$(echo $DATABASE_URL | sed -e 's|^.*:||' -e 's|/.*||' | grep -o '[0-9]*' | head -1)
    DB_DATABASE=$(echo $DATABASE_URL | sed 's|.*/||' | sed 's|?.*||')
    DB_USERNAME=$(echo $DATABASE_URL | sed -e 's|^.*://||' -e 's|:.*||')
    DB_PASSWORD=$(echo $DATABASE_URL | sed -e 's|^[^:]*://[^:]*:||' -e 's|@.*||')
fi

# Crear .env
cat > .env << EOF
APP_NAME="Agencia de Tickets"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}

LOG_CHANNEL=stderr
LOG_LEVEL=error

DB_CONNECTION=${DB_CONNECTION:-pgsql}
DB_HOST=${DB_HOST:-127.0.0.1}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE:-agencia_tickets}
DB_USERNAME=${DB_USERNAME:-postgres}
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
