FROM ubuntu:22.04

ENV TIMEZONE America/Sao_Paulo
ENV DEBIAN_FRONTEND="noninteractive"

COPY . /var/www/bot-discord
WORKDIR /var/www/bot-discord

# system requirements
RUN apt-get update
RUN apt install -y zip unzip ffmpeg opus-tools libopus-dev libsodium-dev

# install php
RUN apt-get install -y php

# Install php extensions
RUN apt-get install -y php-soap php-xml php-curl php-gd php-mbstring

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ENTRYPOINT ["/usr/local/bin", "composer install -n"]