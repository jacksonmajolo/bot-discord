FROM php:7.4-cli
RUN apt-get update && \
    apt install -y \
    ffmpeg \
    opus-tools \
    libopus-dev \
    libsodium-dev
WORKDIR /var/www/bot-discord
CMD [ "php", "./server.php" ]