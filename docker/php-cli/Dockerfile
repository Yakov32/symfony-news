FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev \
    cron

RUN docker-php-ext-install pdo pdo_mysql zip

RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet

ADD run.sh /run.sh
ADD entrypoint.sh /entrypoint.sh

RUN chmod +x /run.sh /entrypoint.sh

ENTRYPOINT /entrypoint.sh

WORKDIR /symfony