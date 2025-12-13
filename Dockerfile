# Gunakan image PHP resmi dengan Apache
FROM php:8.2-apache

# Install dependency sistem yang diperlukan Laravel
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

# Install ekstensi PHP yang wajib
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Aktifkan mod_rewrite Apache (biar route Laravel jalan)
RUN a2enmod rewrite

# Install Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install NodeJS dan NPM (untuk build aset frontend)
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# Set folder kerja
WORKDIR /var/www/html

# Copy file composer dulu (biar cache optimal)
COPY composer.json composer.lock ./

# Install dependensi PHP (tanpa dev tools biar ringan)
RUN composer install --no-dev --no-scripts --no-autoloader

# Copy seluruh file project ke dalam container
COPY . .

# Buat folder storage link secara manual di dalam container (BUKAN copy dari laptop)
RUN php artisan storage:link

# Jalankan build frontend (Vite/Blade)
RUN npm install && npm run build

# Finalisasi install composer
RUN composer dump-autoload --optimize

# Atur permission folder storage (supaya bisa upload gambar)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Atur Document Root ke folder public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Expose port (Railway akan override ini, tapi standar Docker butuh ini)
EXPOSE 80