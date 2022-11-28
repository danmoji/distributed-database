FROM php:8.1-apache
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN docker-php-ext-enable mysqli
RUN apt-get update && apt-get install libcurl4-openssl-dev
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN docker-php-ext-install curl