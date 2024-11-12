#!/bin/sh

mix_env=$1

if [ ! -f database/database.sqlite ]; then
  sqlite3 database/database.sqlite "VACUUM;"
fi

if [ "$mix_env" == "" ]; then
  mix_env="production"
fi

CR=podman
$CR run --rm --entrypoint bash -it -v .:/app docker.io/library/node -c "cd /app && npm install && npm run $mix_env"
$CR run --rm -it -v .:/app docker.io/library/composer install
$CR run --rm --env-file=.setup-env -it -v .:/app docker.io/library/php:8 bash -c "cd /app && php artisan migrate"
