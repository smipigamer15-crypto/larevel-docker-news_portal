FROM php:8.2-apache

# Встановлюємо системні залежності
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# Встановлюємо PHP розширення
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Включаємо mod_rewrite
RUN a2enmod rewrite

# Встановлюємо Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Робоча директорія
WORKDIR /var/www/html

# Копіюємо файли
COPY . .

# Встановлюємо права
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Налаштовуємо Apache - ЗМІНЮЄМО DOCUMENT ROOT НА PUBLIC
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]