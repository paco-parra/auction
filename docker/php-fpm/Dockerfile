FROM php:7.2-fpm

RUN apt-get update \
    && apt-get install -y vim nano \
    && apt-get install -y libxml2-dev

RUN docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install xml \
    && docker-php-ext-install soap

COPY "./ini/php.ini-development" "/usr/local/etc/php/php.ini"

WORKDIR /var/www