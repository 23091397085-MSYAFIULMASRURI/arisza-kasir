FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libjpeg-dev libonig-dev libxml2-dev zip sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copy Apache vhost
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf
