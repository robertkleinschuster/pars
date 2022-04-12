FROM php:8.1.4-fpm AS pars_php

RUN docker-php-source extract \
    && apt-get update \
    && apt-get install -y libicu-dev libtidy-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure pdo_mysql \
    && docker-php-ext-configure tidy \
    && docker-php-ext-install intl pdo_mysql tidy \
    && docker-php-ext-enable opcache intl pdo_mysql tidy \
    && docker-php-source delete

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000