
FROM php:8.3-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        mbstring \
        bcmath \
        exif \
        pcntl \
        gd \
        intl \
        zip \
        opcache \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Enable PHP error logging for Render logs
RUN echo "log_errors=On" > /usr/local/etc/php/conf.d/laravel-logging.ini \
    && echo "error_log=/dev/stderr" >> /usr/local/etc/php/conf.d/laravel-logging.ini \
    && echo "display_errors=Off" >> /usr/local/etc/php/conf.d/laravel-logging.ini

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js and npm
COPY --from=node:22-bookworm-slim /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22-bookworm-slim /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

WORKDIR /var/www/html

# Copy Composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-scripts \
    --optimize-autoloader

# Copy frontend dependency files
COPY package.json package-lock.json ./

# Install frontend dependencies
RUN npm ci

# Copy complete Laravel application
COPY . .

# Configure Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Configure Apache to listen on Render port 10000
RUN sed -i 's/^Listen 80$/Listen 10000/' /etc/apache2/ports.conf \
    && sed -ri 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' \
       /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Ensure Laravel directories exist
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Set Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache

# Build Vite assets. Remove any stale Vite dev-server marker so Laravel uses
# the production manifest when rendering @vite() tags in the container.
RUN rm -f public/hot \
    && npm run build \
    && test -s public/build/manifest.json

# Regenerate Composer autoload files
RUN composer dump-autoload \
    --no-dev \
    --optimize \
    --no-scripts \
    --no-interaction

# Render web service port
EXPOSE 10000

CMD ["bash", "-lc", "php artisan migrate --force && if [ \"${SEED_ADMIN_ON_START:-false}\" = \"true\" ]; then php artisan db:seed --force; fi && exec apache2-foreground"]
