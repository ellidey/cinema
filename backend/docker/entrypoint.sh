#!/usr/bin/env sh
set -eu

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force --no-interaction >/dev/null 2>&1 || true
php artisan migrate --force --no-interaction || true

exec "$@"
