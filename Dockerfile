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

# --- BAGIAN HAPUS PAKSA ERROR MPM (SOLUSI BARU) ---
# Kita hapus manual file konfigurasi mpm_event dan mpm_worker agar tidak bisa hidup lagi
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load
RUN rm -f /etc/apache2/mods-enabled/mpm_event.conf
RUN rm -f /etc/apache2/mods-enabled/mpm_worker.load
RUN rm -f /etc/apache2/mods-enabled/mpm_worker.conf

# Paksa aktifkan mpm_prefork (satu-satunya yang boleh hidup)
RUN a2enmod mpm_prefork rewrite
# --------------------------------------------------

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Install NodeJS dan NPM
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# Set folder kerja
WORKDIR /var/www/html

# 6. Copy semua file
COPY . .

# 7. Bersihkan vendor lama & Install Composer
RUN rm -rf vendor composer.lock
RUN composer install --no-dev --optimize-autoloader

# 8. Buat .env dummy & Storage Link
RUN touch .env
RUN php artisan storage:link

# 9. Build Frontend
RUN npm install && npm run build

# 10. Permission Folder
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 11. Setting Document Root ke Public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 12. Expose Port 80
EXPOSE 80