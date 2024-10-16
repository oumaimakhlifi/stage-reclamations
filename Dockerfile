FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copier les fichiers du répertoire local vers le répertoire de travail dans le conteneur
COPY . /var/www/html/

# Changer le propriétaire des fichiers pour l'utilisateur www-data
RUN chown -R www-data:www-data /var/www/html

# Créer un fichier index.php pour rediriger vers user_dashboard.php
RUN echo "<?php include('user_dashboard.php'); ?>" > /var/www/html/index.php

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
