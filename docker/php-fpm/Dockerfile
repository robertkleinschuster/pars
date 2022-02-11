FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

CMD ["php-fpm"]

EXPOSE 9000