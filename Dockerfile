FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN chown -R www-data:www-data /var/www

RUN composer install --no-interaction --optimize-autoloader --no-dev

EXPOSE 9000

CMD ["php-fpm"]
