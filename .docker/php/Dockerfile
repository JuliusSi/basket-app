FROM php:8.1-fpm

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql bcmath
RUN pecl install xdebug \
	&& docker-php-ext-enable xdebug
COPY php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
