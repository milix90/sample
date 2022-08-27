FROM php:8.0

RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql sockets

WORKDIR /app
COPY client .

RUN chown -R www-data:www-data /app

RUN composer install

CMD php -S 0.0.0.0:8000 -t public
EXPOSE 8000