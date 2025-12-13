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

# Aktifkan .htaccess Laravel
COPY docker/apache.conf /etc/apache2/conf-available/laravel.conf
RUN a2enconf laravel


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
# RUN touch .env
RUN php artisan storage:link
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Atur Document Root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 10. Expose Port 80
EXPOSE 80

# --- SOLUSI PAMUNGKAS ---
# Kita ganti perintah start default.
# Script ini akan menghapus paksa config yang bentrok TEPAT SEBELUM website nyala.
# Jadi linux tidak punya waktu untuk mengembalikannya.
CMD ["/bin/bash", "-c", "rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf && apache2-foreground"]