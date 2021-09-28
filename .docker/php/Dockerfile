FROM php:8.0.3-fpm-alpine

RUN apk add --no-cache openssl bash mysql-client nodejs npm git nano gcc make

RUN docker-php-ext-install pdo pdo_mysql bcmath

RUN apk add \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

RUN rm -rf /var/www/html
RUN ln -s public html

RUN curl -Ss https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000

ENTRYPOINT ["php-fpm"]
