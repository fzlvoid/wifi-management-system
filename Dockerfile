FROM node:22-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build

FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    postgresql-dev \
    libzip-dev \
    nginx

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    bcmath \
    exif \
    pcntl \
    gd \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

RUN echo 'server { \
    listen 8080; \
    root /var/www/public; \
    index index.php index.html; \
    location / { try_files $uri $uri/ /index.php?$query_string; } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name; \
        include fastcgi_params; \
    } \
}' > /etc/nginx/http.d/default.conf

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

COPY . .

RUN composer run-script post-autoload-dump

COPY --from=node-builder /app/public/build ./public/build

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

RUN echo '#!/bin/sh' > /start.sh \
    && echo 'php artisan config:cache' >> /start.sh \
    && echo 'php artisan route:cache' >> /start.sh \
    && echo 'php artisan view:cache' >> /start.sh \
    && echo 'php-fpm -D' >> /start.sh \
    && echo 'nginx -g "daemon off;"' >> /start.sh \
    && chmod +x /start.sh


EXPOSE 8080

CMD ["/start.sh"]