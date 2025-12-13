# Gunakan image PHP resmi dengan Apache
FROM php:8.2-apache

# Install dependency sistem
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev

# Bersihkan cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install NodeJS dan NPM
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# Set folder kerja
WORKDIR /var/www/html

# 1. Copy dulu SEMUA file project dari laptop ke server
COPY . .

# 2. Hapus folder vendor jika tidak sengaja ke-copy dari laptop
RUN rm -rf vendor composer.lock

# 3. Baru jalankan install composer
RUN composer install --no-dev --optimize-autoloader

# --- BAGIAN YANG DIHAPUS: key:generate ---
# Kita hapus perintah key:generate karena key sudah ada di Railway Variables.

# 4. Buat file .env kosong sementara (PENTING AGAR TIDAK ERROR LAINNYA)
# Ini trik supaya artisan tidak komplain file .env hilang
RUN touch .env

# 5. Jalankan artisan storage:link
RUN php artisan storage:link

# 6. Jalankan build frontend
RUN npm install && npm run build

# Atur permission folder storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Atur Document Root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Expose port
EXPOSE 80