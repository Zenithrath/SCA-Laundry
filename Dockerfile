# ===============================
# BASE IMAGE
# ===============================
FROM php:8.2-apache

# ===============================
# 1. SYSTEM DEPENDENCIES
# ===============================
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ===============================
# 2. PHP EXTENSIONS
# ===============================
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# ===============================
# 3. APACHE CONFIG
# ===============================
# Enable rewrite (WAJIB untuk Laravel)
RUN a2enmod rewrite

# Set DocumentRoot ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Ubah DocumentRoot hanya di VirtualHost
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf

# Izinkan .htaccess Laravel
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' \
    /etc/apache2/apache2.conf

# ===============================
# 4. COMPOSER
# ===============================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ===============================
# 5. WORKDIR
# ===============================
WORKDIR /var/www/html

# ===============================
# 6. COPY SOURCE CODE
# ===============================
COPY . .

# ===============================
# 7. INSTALL BACKEND & FRONTEND
# ===============================
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# ===============================
# 8. LARAVEL SETUP
# ===============================
RUN php artisan storage:link || true

RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# ===============================
# 9. APACHE PORT
# ===============================
EXPOSE 80

# ===============================
# 10. START APACHE
# ===============================
CMD ["apache2-foreground"]
