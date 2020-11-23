FROM php:7.3-fpm-buster

RUN apt-get update && apt-get install -y nano git make curl wget unzip libpq-dev libcurl4-gnutls-dev libicu-dev libmcrypt-dev \
    libvpx-dev libjpeg-dev libpng-dev libxpm-dev zlib1g-dev libfreetype6-dev libxml2-dev libexpat1-dev libbz2-dev libgmp3-dev \
    libldap2-dev unixodbc-dev libpq-dev libsqlite3-dev libaspell-dev libsnmp-dev libpcre3-dev libtidy-dev libpng-dev libzip-dev \
    librabbitmq-dev libssh-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN docker-php-ext-install bcmath fileinfo sockets iconv json pgsql mbstring pdo pdo_pgsql curl intl xml zip bz2 opcache gd
RUN pecl install amqp && docker-php-ext-enable amqp
RUN mkdir /var/www/app
WORKDIR /var/www/app

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

EXPOSE 9000

CMD ["make", "install_dev"]
