#!/bin/bash

set -e

if [ ! -f /var/www/vendor ]; then
    echo "> initialize project"

    curl -sS https://getcomposer.org/installer | php

    export SYMFONY_ENV=prod
    php composer.phar install --no-dev --optimize-autoloader

    php app/console cache:clear --env=prod --no-debug
    php app/console cache:warmup --env=prod --no-debug
fi


if [ ! -f /var/www/app/database/data.db3 ]; then
    echo "> initialize database"
    php app/console doctrine:database:create
fi

echo "> run migrations"
php app/console doctrine:migrations:migrate --no-interaction


echo "> fix permissions"
chown -R www-data:www-data /var/www


echo "> starting up webservice"
exec "$@"
