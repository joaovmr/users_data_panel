# Use the official PHP image for Laravel
FROM php:8.1-fpm

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and npm with version 20.0.0
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy the application code into the container
COPY . .

# Install Composer dependencies
RUN composer install --no-interaction --no-plugins --no-scripts --no-suggest --optimize-autoloader

# Install npm dependencies
RUN npm install

# Copy the example configuration file
RUN cp .env.example .env

# Generate the application key
RUN php artisan key:generate

# Expose port 8000
EXPOSE 8000

# Start the PHP built-in server
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000"]
