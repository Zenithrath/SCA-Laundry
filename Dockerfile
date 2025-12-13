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
    libzip-dev

# 2. Bersihkan cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Install ekstensi PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 4. Aktifkan mod_rewrite
RUN a2enmod rewrite

# 5. Install Composer & Node
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# Set folder kerja
WORKDIR /var/www/html

# 6. Copy semua file
COPY . .

# 7. Install Vendor & Build Frontend
RUN rm -rf vendor composer.lock
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# 8. Setup Laravel
RUN touch .env
RUN php artisan storage:link
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# 9. Atur Document Root (INI WAJIB UNTUK LOGIN)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 10. IZINKAN .htaccess (INI YANG HANDLE LOGIN ROUTING)
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# 11. Expose Port
EXPOSE 80

# ❌ CMD HACK MPM DIHAPUS TOTAL
# ✅ Pakai default apache2-foreground
CMD ["apache2-foreground"]
