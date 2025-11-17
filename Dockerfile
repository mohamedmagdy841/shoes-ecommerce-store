FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
        libxml2-dev \
        oniguruma-dev \
        curl-dev \
        openssl-dev \
        postgresql-dev \
        libzip-dev \
        icu-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        git \
        unzip \
        nodejs \
        npm

RUN docker-php-ext-install intl \
    && pdo pdo_pgsql mbstring xml curl zip opcache \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

WORKDIR /var/www/html

COPY . .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV LARAVEL_SKIP_PACKAGE_DISCOVERY=1


RUN composer install --no-dev --optimize-autoloader --no-scripts

RUN npm install && npm run build

RUN mkdir -p storage/framework/{sessions,views,cache} \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

CMD ["php-fpm"]
