FROM php:8.0-cli
RUN apt-get update && \
    apt install -y \
    ffmpeg \
    opus-tools \
    libopus-dev \
    libsodium-dev
WORKDIR /var/www/bot-discord
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
CMD [ "php", "./server.php" ]