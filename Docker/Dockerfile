FROM php:8.2-apache

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini


# Dependencies voor composer en QR-code lib
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite \
    && pecl install xdebug

RUN apt-get update && apt-get install -y tzdata \
    && ln -fs /usr/share/zoneinfo/Europe/Amsterdam /etc/localtime \
    && dpkg-reconfigure -f noninteractive tzdata

ENV TZ=Europe/Amsterdam

RUN mkdir /app

# Composer installeren
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Document root naar /var/www/html
