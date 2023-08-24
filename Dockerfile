FROM php:8.1

RUN apt-get -y update && apt-get install -y \
    libc6-dev \
    libsasl2-dev \
    libsasl2-modules \
    libssl-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    libpng-dev \
    libzip-dev \
    zlib1g-dev \
    libxml2-dev \
    libonig-dev \
    graphviz \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-install sockets \
    && docker-php-source delete \
    && curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin --filename=composer


RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git


WORKDIR /app
COPY . .
RUN composer install
