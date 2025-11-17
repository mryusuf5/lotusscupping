##############################
# 1) Node stage – build assets
##############################
FROM node:20 AS assets

WORKDIR /app

# Copy only package files first for better caching
COPY package.json ./

# Install JS dependencies
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi

# Copy only what’s needed for asset building
COPY assets ./assets
COPY webpack.config.js ./

# Build assets for production
ENV NODE_ENV=production
RUN npm run build


##############################
# 2) PHP stage – Symfony app
##############################
FROM php:8.2-cli AS symfony

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    libpng-dev \
    && docker-php-ext-install \
        intl \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        zip \
        opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy full project (source, config, templates, etc.)
COPY . /app

# Copy built Webpack assets from Node stage into public/build
COPY --from=assets /app/public/build /app/public/build

# Install PHP dependencies for production
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress

# (Optional) Warm up Symfony cache
# RUN php bin/console cache:warmup --env=prod

# Environment for Symfony
ENV APP_ENV=prod \
    APP_DEBUG=0

# Render will pass $PORT, fallback to 8000 locally
EXPOSE 8000

# Start Symfony using PHP's built-in web server
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8000} -t public"]
