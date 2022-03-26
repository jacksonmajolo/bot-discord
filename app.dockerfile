FROM php:8.0-cli

COPY . /var/www/bot-discord
WORKDIR /var/www/bot-discord

# system requirements
RUN apt-get update
RUN apt install -y zip unzip ffmpeg opus-tools libopus-dev libsodium-dev

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENTRYPOINT ["composer install -n"]