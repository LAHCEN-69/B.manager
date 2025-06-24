FROM php:8.2-apache

# Enable Apache Rewrite Module
RUN a2enmod rewrite

# Change DocumentRoot to /var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Install required extensions
RUN apt-get update && apt-get install -y \
    libzip-dev unzip curl git sqlite3 \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate Laravel key (dummy for build)
RUN php artisan key:generate --ansi || true

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
