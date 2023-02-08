FROM php:8.2-fpm as php

ARG DEBIAN_FRONTEND=noninteractive

# Projenin konumu belirleniyor
WORKDIR /var/www
RUN rm -rf /var/www/*

# Gerekli Kaynaklar Hazırlanıyor..
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Tüm kurulum işlemleri yapılıyor
RUN \
    # Temizlik Yapılıyor..
    apt-get clean autoclean && apt-get -y autoremove && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    \
    # Güncelleme Yapılıyor..
    && apt-get update -y \
    \
    # PHP Kütüphanelerinin Kurulması İçin Gerekli Hazırlık Yapılıyor..
    && chmod +x /usr/local/bin/install-php-extensions && sync \
    \
    # Gerekli Yazılımlar Kuruluyor..
    && apt-get install -y \
        procps \
        iputils-ping \
        telnet \
        openssl \
        libcurl4-gnutls-dev \
        nginx \
        build-essential \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libonig-dev \
        zip unzip \
        jpegoptim optipng pngquant gifsicle \
        vim \
        git \
        curl \
        nano \
        gnupg \
        libssl-dev \
        apt-utils \
        libsodium-dev  \
        gosu \
        ca-certificates \
        supervisor \
        sqlite3 \
        libcap2-bin \
        nodejs npm \
        default-mysql-client \
    \
    # ImageMagick
    # https://github.com/freekmurze/freek-dev-comments/issues/59#issuecomment-803560832
    && apt-get install -y imagemagick libmagickwand-dev libmagickcore-dev \
    \
    # Zip
    && apt-get -y install libzip-dev zip unzip && docker-php-ext-configure zip && docker-php-ext-install zip \
    \
    # Curl
    && apt-get install -y libcurl3-dev curl && docker-php-ext-install curl \
    \
    # GD
    && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && docker-php-ext-install gd \
    \
    # Locales
    && apt-get install -y locales && locale-gen tr_TR.UTF-8 && dpkg-reconfigure locales \
    \
    # Human Language and Character Encoding Support
    # Install PHP extensions intl (intl requires to be configured) \
    # Install icu dev libs support
    && apt-get install -y zlib1g-dev libicu-dev g++ && docker-php-ext-configure intl && docker-php-ext-install intl \
    \
    ## PHP İçin Gerekli Kurulumlar Yapılıyor
    && install-php-extensions exif pcntl \
    \
    # BC Math
    && docker-php-ext-install bcmath \
    \
    # Yarn
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && apt-get update -y && apt-get install -y yarn \
    \
    # PDO, MySQL and Postgres/pgsql
    && docker-php-ext-install pdo mysqli pdo_mysql && docker-php-ext-enable pdo_mysql \
    && apt-get install -y libpq-dev && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-install pdo_pgsql pgsql \
    \
    # Temizlik Yapılıyor..
    && apt-get clean autoclean && apt-get -y autoremove && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY ./deploy/php/php-fpm.ini /usr/local/etc/php/php-99.ini
COPY ./deploy/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./deploy/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./deploy/nginx/default.conf /etc/nginx/conf.d/
COPY ./deploy/entrypoint.sh /entrypoint.sh

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Dosyalar kopyalanıyor ve yetkileri veriliyor..
COPY --chown=www-data:www-data . .

# Projenin kurulum işlemleri yapılıyor
RUN \
    # Composer paketleri güncelleniyor..
    composer install --no-cache && composer dump-autoload -o && composer clear-cache \
    \
    # Frontend işlemleri tamamlanıyor..
    yarn install && yarn prod && yarn cache clean --all \
    \
    # Yetkiler güncelleniyor..
    && chown -R www-data:www-data vendor/ composer.lock \
    && chmod -R 755 /var/www/storage && chmod -R 755 /var/www/bootstrap \
    && chmod +x /entrypoint.sh \
    \
    # Cache temizleme işlemleri yapılıyor.. \
    # https://stackoverflow.com/a/33427572
    && php artisan clear-compiled || : \
    && php artisan cache:clear || : \
    && php artisan config:clear || : \
    && php artisan event:clear || : \
    && php artisan optimize:clear || : \
    && php artisan route:clear || : \
    && php artisan view:clear || :

ENTRYPOINT [ "/entrypoint.sh" ]

# docker build -f ./Dockerfile -t acikkaynak/deprem-yardimi:latest .
# docker push acikkaynak/deprem-yardimi
# docker run -it -p 8000:80 --env-file .env acikkaynak/deprem-yardimi

