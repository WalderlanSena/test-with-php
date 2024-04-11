FROM php:8.3-cli

RUN apt-get update && apt-get install -y git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY composer.json composer.lock* /app/

RUN composer install

COPY . /app

CMD ["tail", "-f", "/dev/null"]