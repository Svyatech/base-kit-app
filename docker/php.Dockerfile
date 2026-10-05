# Базовый образ PHP для всех сайтов: FrankenPHP (веб-сервер + PHP 8.5 в одном)
# + расширения + composer + прод-настройки PHP.
# Собирается редко: make build-base
FROM dunglas/frankenphp:php8.5

RUN install-php-extensions \
        pdo_pgsql \
        gd \
        intl \
        zip \
        redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php/opcache.ini $PHP_INI_DIR/conf.d/opcache.ini

COPY docker/caddy/Caddyfile.app /etc/frankenphp/Caddyfile

WORKDIR /var/www/html
EXPOSE 80
