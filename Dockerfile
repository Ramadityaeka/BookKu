FROM php:8.1-apache

# Install ekstensi MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Aktifkan mod_rewrite Apache (penting untuk CI4)
RUN a2enmod rewrite

# Copy file project
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install dependencies composer
RUN composer install --no-dev --optimize-autoloader

# Copy config Apache agar .htaccess aktif di /public
COPY apache-config.conf /etc/apache2/sites-enabled/000-default.conf

# Permission (opsional)
RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80