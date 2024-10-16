FROM php:7.4-apache

# Copy Apache configuration
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy startup script
COPY start-apache /usr/local/bin/start-apache
RUN chmod +x /usr/local/bin/start-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application source directly from stage-reclamations
COPY stage-reclamations /var/www/html/  # Copie le code source dans le répertoire web d'Apache
RUN chown -R www-data:www-data /var/www/html  # Modifier la propriété du répertoire

# Start Apache
CMD ["start-apache"]
