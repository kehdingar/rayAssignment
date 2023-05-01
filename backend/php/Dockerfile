FROM php:8.1.18-fpm-alpine3.17


# Install PHP extensions
RUN docker-php-ext-install pdo_mysql
# RUN docker-php-ext-install mysqli

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .
