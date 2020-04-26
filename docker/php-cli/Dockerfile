FROM php:7.2-cli

RUN apt-get update && apt-get install -y libzip-dev zlib1g-dev libxml2-dev

RUN pecl install xdebug-2.6.0 \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install zip \
    && docker-php-ext-install soap

RUN apt-get update && apt-get install -y default-mysql-client && rm -rf /var/lib/apt    
RUN apt-get update && apt-get install -y vim nano

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY "./ini/php.ini-development" "/usr/local/etc/php/php.ini"

WORKDIR /var/www