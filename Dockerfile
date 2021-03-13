FROM php:7.4-cli
RUN apt-get update && \
    apt install -y \
    ffmpeg \
    opus-tools \
    libopus-dev \
    libsodium-dev
COPY . /usr/src/bot-discord
WORKDIR /usr/src/bot-discord
CMD [ "php", "./server.php" ]