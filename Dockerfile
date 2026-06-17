FROM php:8.2-apache

# Встановлюємо системні залежності
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# Встановлюємо PHP-розширення
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

RUN a2enmod rewrite

# Встановлюємо Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Копіюємо файли проекту
COPY . .

# Встановлюємо залежності Composer (без dev-пакетів, для продакшну)
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Створюємо папки та встановлюємо права
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 755 storage bootstrap/cache

# Змінюємо DocumentRoot на public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80