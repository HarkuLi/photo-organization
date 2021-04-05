FROM composer:2.0 AS builder

COPY . .
RUN composer install --ignore-platform-reqs

FROM php:8.0-alpine

RUN mkdir /app
WORKDIR /app

RUN set -xe \
    && docker-php-ext-install \
        bcmath \
        exif

COPY . .
COPY --from=builder /app/vendor vendor

CMD ["php", "artisan", "photo:organize"]
