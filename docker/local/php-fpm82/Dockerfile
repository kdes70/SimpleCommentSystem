FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

COPY --from=composer/composer /usr/bin/composer /usr/bin/composer

COPY . /var/www/html/

WORKDIR /var/www/html

RUN composer install --no-interaction --no-scripts --no-progress --prefer-dist

COPY ./docker/local/php:82-apache/check_and_create_dir.sh /usr/local/bin/check_and_create_dir.sh
RUN chmod +x /usr/local/bin/check_and_create_dir.sh  \
    && /usr/local/bin/check_and_create_dir.sh \
    && chown -R www-data:www-data /var/www/html/storage

RUN composer install --no-interaction --no-scripts --no-progress --prefer-dist

RUN npm install

RUN chmod -R 755 /var/www/html/storage
