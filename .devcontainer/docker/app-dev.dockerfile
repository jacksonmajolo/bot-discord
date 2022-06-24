FROM ubuntu:22.04

ENV LAST_UPDATED 2022-06-22
ENV TIMEZONE America/Sao_Paulo
ENV DEBIAN_FRONTEND="noninteractive"

# system requirements
RUN apt-get update
RUN apt install -y vim zip unzip ffmpeg opus-tools libopus-dev libsodium-dev git

# install php
RUN apt-get install -y php

# Install php extensions
RUN apt-get install -y php-soap php-xml php-curl php-gd php-mbstring php-xdebug

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 9003
WORKDIR /var/www/bot-discord