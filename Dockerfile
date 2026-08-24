# Official PHP with Apache runtime for Render deployment
FROM php:8.2-apache

# Install and enable mysqli extension for MySQL database connections
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy project files into Apache webroot
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Expose standard HTTP port
EXPOSE 80
