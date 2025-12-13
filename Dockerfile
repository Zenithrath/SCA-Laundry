# Gunakan image PHP resmi dengan Apache
FROM php:8.2-apache

# 1. Install dependency sistem
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    nodejs \
    npm

# 2. Install ekstensi PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3. FIX MPM (INI INTINYA)
RUN a2dismod mpm_event mpm_worker \
    && a2enmod mpm_prefork rewrite

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set folder kerja
WORKDIR /var/www/html

# 6. Copy semua file project
COPY . .

# 7. Install Backend & Frontend
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# 8. Setup Laravel
RUN php artisan storage:link || true
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# 9. Atur Document Root ke /public (WAJIB)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' \
    /etc/apache2/apache2.conf

# 10. Expose Port
EXPOSE 80

# 11. Start Apache
CMD ["apache2-foreground"]
