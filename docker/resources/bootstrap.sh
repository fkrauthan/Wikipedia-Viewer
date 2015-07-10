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


if [ -f /var/database/data.db3 ]; then
    echo "> linking existing database"
    ln -s /var/database/data.db3 /var/www/app/database/data.db3
fi


if [ ! -f /var/www/app/database/data.db3 ]; then
    echo "> initialize database"
    php app/console doctrine:database:create

    chown www-data:www-data /var/www/app/database/data.db3

    mv /var/www/app/database/data.db3 /var/database/data.db3
    ln -s /var/database/data.db3 /var/www/app/database/data.db3
fi

echo "> run migrations"
php app/console doctrine:migrations:migrate --no-interaction


echo "> fix permissions"
chown -R www-data:www-data /var/www
chown -R www-data:www-data /var/database
chown -R www-data:www-data /var/www/app/database/data.db3
chmod 777 /var/www/app/database
chmod 777 /var/www/app/database/data.db3
chmod 777 /var/database
chmod 777 /var/database/data.db3


echo "> starting up webservice"
exec "$@"
