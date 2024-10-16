FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copier les fichiers de votre projet dans le conteneur
COPY . /var/www/html/

# Changer le propriétaire des fichiers pour l'utilisateur www-data
RUN chown -R www-data:www-data /var/www/html

# Définir les permissions pour le répertoire HTML
RUN find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \;

# Exposer le port 80
EXPOSE 80

# Démarrer Apache en mode premier plan
CMD ["apache2-foreground"]
