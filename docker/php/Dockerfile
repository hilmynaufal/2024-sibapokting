FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libpq-dev \
    libzip-dev \
    && docker-php-ext-install \
    pdo_pgsql pgsql \
    mbstring exif bcmath gd \
    zip ftp

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

RUN chown -R www-data:www-data /var/www
