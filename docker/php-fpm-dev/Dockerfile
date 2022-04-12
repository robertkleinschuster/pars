FROM composer:2.3.4 AS pars_composer
FROM php:8.1.4-fpm AS pars_php

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

RUN docker-php-source extract \
    && apt-get update \
    && apt-get install -y libicu-dev libtidy-dev \
    && pecl install xdebug  \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure pdo_mysql \
    && docker-php-ext-configure tidy \
    && docker-php-ext-install intl pdo_mysql tidy \
    && docker-php-ext-enable opcache intl pdo_mysql tidy xdebug \
    && docker-php-source delete

COPY --from=pars_composer /usr/bin/composer /usr/bin/composer

COPY entrypoint.sh /usr/local/bin/entrypoint

RUN chmod 755 /usr/local/bin/entrypoint

WORKDIR /var/www

ENTRYPOINT ["entrypoint"]
CMD ["php-fpm"]

EXPOSE 9000
EXPOSE 9003