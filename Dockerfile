FROM php:8.2-apache

# Update and upgrade packages
RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y zlib1g-dev libwebp-dev libpng-dev && \
    docker-php-ext-install gd && \
    apt-get install -y libzip-dev && \
    docker-php-ext-install zip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite module
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80
