FROM php:8.2-apache

ARG uid=1000
ARG gid=1000

#1. Creating a user with same UID/GID with host user so when execute
#  commands from host, the files created will have the same permissions
RUN addgroup --gid $gid user
RUN adduser --disabled-password --gecos '' --uid $uid --gid $gid user

#2. Update and install packages
RUN apt update
RUN apt upgrade -y

RUN apt-get install -y postgresql \
        libpq-dev \
        curl \
        git \
        zip \
        libzip-dev \
        nano \
        && a2enmod \
        rewrite \
        && docker-php-ext-install zip

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - &&\
    apt-get install -y nodejs \
    build-essential

RUN docker-php-ext-install pgsql pdo_pgsql

#3. Install composer
RUN set -x \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

USER user
