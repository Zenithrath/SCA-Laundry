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

# 4. Aktifkan mod_rewrite (Wajib buat Laravel)
RUN a2enmod rewrite

# 5. Install Composer & Node
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# Set folder kerja
WORKDIR /var/www/html

# 6. Copy semua file project
COPY . .

# 7. Install Vendor & Build Frontend
RUN rm -rf vendor composer.lock
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# 8. Setup Laravel (Env & Storage)
RUN touch .env
RUN php artisan storage:link
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Atur Document Root ke Public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# --- LANGKAH 10: OBAT ANTI CRASH (DIPINDAH KE AKHIR) ---
# Kita hapus SEMUA konfigurasi mpm di folder enabled
# Ini dilakukan paling terakhir supaya tidak ketimpa settingan lain
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load
RUN rm -f /etc/apache2/mods-enabled/mpm_*.conf

# Lalu aktifkan HANYA mpm_prefork secara manual
RUN a2enmod mpm_prefork
# -------------------------------------------------------

# 11. Expose Port
EXPOSE 80