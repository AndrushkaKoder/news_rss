FROM php:8.4-fpm-alpine

RUN set -ex && \
    apk --no-cache --update add \
        linux-headers \
        git \
        postgresql \
        postgresql-dev \
        libxml2-dev \
        oniguruma-dev \
        libpng \
        libjpeg-turbo \
        freetype-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        libzip-dev \
        bash \
        npm \
        autoconf \
        build-base \
        libmemcached-dev \
        libmemcached \
        zlib-dev \
        cyrus-sasl-dev

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg && \
    docker-php-ext-install \
    opcache \
    pdo \
    pdo_pgsql \
    ctype \
    simplexml \
    bcmath \
    fileinfo \
    mbstring \
    xml \
    sockets \
    gd \
    zip \
    intl

RUN pecl channel-update pecl.php.net && \
    pecl install memcached && \
    docker-php-ext-enable memcached

RUN pecl install xdebug-3.4.2 && \
    docker-php-ext-enable xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000