FROM php:8.3-fpm

WORKDIR /var/www
# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip

COPY ./laravel .
#Чтобы избежать ошибки "Failed to open stream: Permission denied"
RUN chgrp -R www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R ug+rwx /var/www/storage /var/www/bootstrap/cache \
