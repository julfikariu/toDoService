# ==============================================================================
# 1. Base Image - Setup base dependencies
# ==============================================================================
FROM php:8.3-fpm AS base

# Set working directory
WORKDIR /var/www

# Install system dependencies required for Laravel and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install standard robust PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip opcache

# Install Redis extension via PECL
RUN pecl install redis && docker-php-ext-enable redis

# ==============================================================================
# 2. Build Stage - Install Composer & Dependencies
# ==============================================================================
FROM base AS build

# Get Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files to build stage
COPY . .

# Install PHP dependencies
# Note: `--no-dev` ensures only production dependencies are installed
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# ==============================================================================
# 3. Production Stage - Final Lean Image
# ==============================================================================
FROM base AS production

# Copy custom PHP configuration
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Copy application from build stage
COPY --from=build /var/www /var/www

# Set proper permissions for Laravel directories
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Use non-root user (www-data) for security
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
