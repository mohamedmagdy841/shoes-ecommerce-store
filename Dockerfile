# Stage 1: Build Application
FROM composer:2 AS builder
WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader

COPY . .


# Correct permissions for storage & bootstrap
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && chmod -R 775 storage bootstrap/cache


# Stage 2: Production Image
FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
        libxml2-dev \
        oniguruma-dev \
        curl-dev \
        openssl-dev \
        postgresql-dev \
        libzip-dev \
        icu-dev \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        mbstring \
        xml \
        curl \
        zip \
        opcache \
    && docker-php-ext-enable \
        fileinfo \
        session \
        tokenizer

WORKDIR /var/www/html

COPY --from=builder /app .

RUN chown -R www-data:www-data storage bootstrap/cache

CMD ["php-fpm"]
