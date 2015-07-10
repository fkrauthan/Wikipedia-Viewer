FROM php:5.6-apache

RUN apt-get update \
    && apt-get install -y libicu-dev libpng-dev libsqlite3-dev \
    && docker-php-ext-install mbstring intl gd

ADD resources/vhost.conf /etc/apache2/sites-enabled/000-default.conf
ADD resources/php.ini /usr/local/etc/php/php.ini

RUN a2enmod rewrite


RUN rm -Rf /var/www
ADD project/ /var/www/
RUN chown -R www-data:www-data /var/www


WORKDIR /var/www


VOLUME ["/var/www/app/database"]


ADD resources/bootstrap.sh /bootstrap.sh
ENTRYPOINT ["/bootstrap.sh"]


EXPOSE 80
CMD ["apache2-foreground"]
