FROM php:8.2-fpm

# System
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev zip

# PHP ext
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Node (za React build ako bude potrebno)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
 && apt-get install -y nodejs