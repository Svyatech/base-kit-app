# Образ сайта: готовый PHP из базового образа + код этого репозитория.
# Весь тяжёлый слой (PHP, расширения, composer, веб-сервер) уже собран
# в base-kit-php, здесь добавляются только код и vendor.
#
# Владелец GHCR подставляется при сборке из GitHub Actions.
# Локально: docker build --build-arg BASE_IMAGE=base-kit-php -t base-kit-app .
ARG BASE_IMAGE
FROM ${BASE_IMAGE}

# Зависимости PHP-приложения — отдельным слоем до кода:
# пересобираются только когда изменился composer.lock
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Код — последним слоем (меняется чаще всего)
COPY . .
RUN composer install --no-dev --optimize-autoloader --prefer-dist \
    && chmod -R 777 storage bootstrap/cache
