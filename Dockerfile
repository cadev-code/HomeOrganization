FROM php:8.2-fpm-alpine

RUN apk add --no-cache postgresql-dev nginx \
    && docker-php-ext-install pdo_pgsql

COPY .docker/nginx.conf /etc/nginx/nginx.conf

WORKDIR /var/www/html

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]