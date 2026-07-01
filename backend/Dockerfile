FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
        bash \
        icu-dev \
        libzip-dev \
        oniguruma-dev \
        postgresql-dev \
        zip \
    && docker-php-ext-install \
        intl \
        mbstring \
        pcntl \
        pdo_pgsql \
        zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

COPY . .

RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rw storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/laravel-entrypoint

ENTRYPOINT ["sh", "/usr/local/bin/laravel-entrypoint"]
CMD ["php-fpm"]
