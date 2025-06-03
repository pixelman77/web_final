FROM php:8.2-apache

# Copy all files into the Apache web root
COPY . /var/www/html/

# Enable Apache Rewrite Module if you use it
RUN a2enmod rewrite

# Open port 80
EXPOSE 80

# Optional: install Composer dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader
