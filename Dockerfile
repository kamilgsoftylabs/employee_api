FROM php:8.0-fpm-alpine

# Update apk and install required packages
RUN apk add --no-cache nginx libpng-dev libjpeg-turbo-dev freetype-dev libzip-dev libbz2 oniguruma-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd pdo_mysql mysqli zip bz2 opcache bcmath && \
    rm -rf /tmp/* /var/cache/apk/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy Nginx configuration files
COPY ./php/nginx.conf /etc/nginx/nginx.conf

# Copy Laravel application code
COPY . /var/www/app

# Set working directory
WORKDIR /var/www/app

# Install Laravel application dependencies
RUN composer update
RUN composer install --no-interaction --no-scripts --prefer-dist --optimize-autoloader

# Copy
COPY .env.example /var/www/app/.env

# Generate Laravel application key
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data /var/www/app/storage /var/www/app/bootstrap/cache
RUN chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache
