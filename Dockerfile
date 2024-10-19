# Use the official PHP image with Apache
FROM php:7.4-apache

# Copy Apache configuration
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite

# Set the correct permissions for the document root
RUN chown -R www-data:www-data /var/www/html/

# Copy application source
COPY . /var/www/html/
# Copie le code source dans le répertoire web d'Apache
