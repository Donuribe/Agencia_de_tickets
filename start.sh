#!/bin/bash
set -e

php artisan migrate --force --no-interaction
php artisan storage:link --force 2>/dev/null || true

echo "Starting PHP server on port ${PORT:-8000}"
exec php -S 0.0.0.0:${PORT:-8000} router.php
