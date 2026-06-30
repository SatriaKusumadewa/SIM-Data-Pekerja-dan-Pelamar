FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip git curl libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node & build Tailwind (Vite)
RUN npm install && npm run build

# Fix Laravel storage
RUN mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/framework/cache \
    && chmod -R 775 storage bootstrap/cache

# Clear cache
RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan optimize:clear

# Expose port
EXPOSE 10000

# Run Laravel (HARUS PALING BAWAH)
CMD php artisan serve --host=0.0.0.0 --port=10000