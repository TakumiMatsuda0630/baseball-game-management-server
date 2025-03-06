# ベースイメージの指定
FROM php:8.2-fpm

# 作成した設定ファイルをコンテナ内にコピー
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini

# 必要なパッケージのインストール
RUN apt-get update \
    && apt-get install -y \
        git \
        zip \
        unzip \
        vim \
        curl \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
        nodejs \
        npm \
        bash \
        libmariadb-dev \
    && docker-php-ext-install zip pdo_mysql \
    && apt-get clean

# composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# コンテナ内で作業する際のカレントディレクトリの指定
WORKDIR /var/www/html
