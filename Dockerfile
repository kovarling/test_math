FROM php:8.0.12-cli-alpine3.13

RUN apk update && apk add git unzip zip

WORKDIR /app

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd bcmath zip intl opcache

COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin/composer