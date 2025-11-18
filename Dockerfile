# ============================================
# Stage 1: Composer Dependencies
# ============================================
FROM composer:2 AS composer-stage

# Install PHP extensions needed by your dependencies
RUN apk add --no-cache --virtual .build-deps \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && apk del .build-deps \
    && apk add --no-cache \
        freetype \
        libjpeg-turbo \
        libpng

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction \
    --prefer-dist

# ============================================
# Stage 2: Node.js Build
# ============================================
FROM node:24-alpine AS node-stage

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci
RUN npm run build

COPY . .

RUN npm run build

# ============================================
# Stage 3: Final Production Image
# ============================================
FROM php:8.3-fpm-alpine

# Install only RUNTIME dependencies (no build tools)
RUN apk add --no-cache \
        libxml2 \
        oniguruma \
        curl \
        openssl \
        postgresql-libs \
        libzip \
        icu \
        freetype \
        libjpeg-turbo \
        libpng

# Install PHP extensions (build deps are auto-removed)
RUN apk add --no-cache --virtual .build-deps \
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
    && docker-php-ext-install intl pdo pdo_pgsql mbstring xml curl zip opcache \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && apk del .build-deps

WORKDIR /var/www/html

# Copy application code
COPY . .

# Copy composer dependencies from Stage 1
COPY --from=composer-stage /app/vendor ./vendor

# Copy built assets from Stage 2
COPY --from=node-stage /app/public/build ./public/build

# Set up Laravel directories
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

CMD ["php-fpm"]

# shoes-ecommerce-store-app:latest             b70ab133116f       1.09GB             0B    U
