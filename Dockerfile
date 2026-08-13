FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl \
    libzip-dev \
    libpng-dev \
    libpq-dev \
    gnupg \
    && docker-php-ext-install \
    zip \
    gd \
    pdo \
    pdo_pgsql

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Install dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# Build frontend
RUN npm install
RUN npm run build

EXPOSE 10000

CMD php artisan optimize:clear && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=10000
