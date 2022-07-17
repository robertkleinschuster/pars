FROM openswoole/swoole:4.11.1-php8.1 AS pars_php

RUN docker-php-source extract \
    && apt-get update \
    && apt-get install -y libicu-dev libtidy-dev git zlib1g-dev unzip \
    && pecl install inotify \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure pdo_mysql \
    && docker-php-ext-configure tidy \
    && docker-php-ext-install intl pdo_mysql tidy \
    && docker-php-ext-enable opcache intl pdo_mysql tidy inotify \
    && docker-php-source delete

WORKDIR /var/www