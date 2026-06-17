FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev libicu-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ===== ТИМЧАСОВІ ЗМІННІ ДЛЯ ЗБІРКИ (щоб artisan не падав) =====
ENV APP_ENV=local
ENV APP_KEY=base64:asMGfKz5KS6j6itGGwKjOFYjtqdS03p/9E7ZMYvrcvg=
ENV DB_CONNECTION=sqlite
ENV SESSION_DRIVER=file
ENV CACHE_DRIVER=file

# Копіюємо ВСІ файли проекту (щоб artisan був доступний)
COPY . .

# Встановлюємо залежності (тепер artisan є, скрипти виконаються)
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Створюємо папки та права
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 755 storage bootstrap/cache

# Змінюємо DocumentRoot
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80