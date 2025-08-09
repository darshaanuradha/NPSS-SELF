FROM php:8.3-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev libgmp-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl gmp

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Increase Composer memory limit
ENV COMPOSER_MEMORY_LIMIT=-1

# Set Laravel environment variables
ENV APP_KEY=base64:7vJ7XB5Ehkkj9CjkxnGExf74j3chK3EpU+tVFY1CulM= \
    APP_ENV=local \
    APP_DEBUG=true \
    DB_CONNECTION=mysql \
    DB_HOST=sql12.freesqldatabase.com \
    DB_PORT=3306 \
    DB_DATABASE=sql12794311 \
    DB_USERNAME=sql12794311 \
    DB_PASSWORD=F7Ae1GP6gX

WORKDIR /var/www/html

# Copy composer files first to leverage cache
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the application files
COPY . .

# Fix permissions for Laravel folders
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Clear and cache config/routes/views
RUN php artisan config:clear && php artisan route:clear && php artisan view:clear
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
