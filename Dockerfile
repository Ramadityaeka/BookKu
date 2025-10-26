FROM php:8.1-apache

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Set ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy all files first
COPY . /var/www/html/

# Copy healthz.php to public folder (with fallback)
RUN cp /var/www/html/healthz.php /var/www/html/public/healthz.php 2>/dev/null || echo "<?php header('Content-Type: text/plain'); echo 'OK';" > /var/www/html/public/healthz.php

# Configure Apache DocumentRoot to point to public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's|<Directory /var/www/html>|<Directory /var/www/html/public>|g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's|<Directory /var/www/>|<Directory /var/www/html/public>|g' /etc/apache2/apache2.conf && \
    sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    mkdir -p /var/www/html/writable/cache /var/www/html/writable/logs /var/www/html/writable/session /var/www/html/writable/uploads && \
    chmod -R 777 /var/www/html/writable

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
