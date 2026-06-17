FROM php:8.2-apache

# Встановлюємо системні залежності для всіх PHP-розширень
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    && rm -rf /var/lib/apt/lists/*

# Встановлюємо PHP-розширення (кожне окремо, щоб бачити помилки)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Вмикаємо mod_rewrite
RUN a2enmod rewrite

# Встановлюємо Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Створюємо папки та встановлюємо права
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 755 storage bootstrap/cache

# Змінюємо DocumentRoot на public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80