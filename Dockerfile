FROM php:8.1-apache

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Set ServerName to suppress warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set DocumentRoot to public folder for CodeIgniter 4
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Configure Apache for CodeIgniter (allow .htaccess)
RUN sed -i '/<Directory \/var\/www\//,<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy all files
COPY . /var/www/html/

# Copy healthz.php to public folder
RUN cp /var/www/html/healthz.php /var/www/html/public/healthz.php || true

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \n    && chmod -R 755 /var/www/html

# Create and set permissions for writable directories
RUN mkdir -p /var/www/html/writable/cache \n    /var/www/html/writable/logs \n    /var/www/html/writable/session \n    /var/www/html/writable/uploads \n    && chown -R www-data:www-data /var/www/html/writable \n    && chmod -R 777 /var/www/html/writable

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]