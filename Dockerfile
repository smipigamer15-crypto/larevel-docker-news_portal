FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev libicu-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ===== ПРИМУСОВА ПЕРЕЗБІРКА (змінюється при кожному запуску) =====
RUN echo "Force rebuild at $(date)" > /tmp/force

# Копіюємо composer.json і composer.lock для кешування
COPY composer.json composer.lock ./

# Встановлюємо залежності
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Копіюємо решту файлів
COPY . .

RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 755 storage bootstrap/cache

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80