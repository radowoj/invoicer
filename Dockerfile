FROM php:7.2-cli-alpine

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app
