# =========================================================================
# 1. 実行環境となるベースイメージ（PHP 8.2 + Apache）
# =========================================================================
FROM php:8.2-apache

# 2. 必要なシステムパッケージとPHP拡張モジュールのインストール
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd bcmath

# 公式の node:20 イメージから、必要なバイナリ（プログラム実行ファイル）だけを丸ごと盗んできます
COPY --from=node:24 /usr/local/bin /usr/local/bin
COPY --from=node:24 /usr/local/lib/node_modules /usr/local/lib/node_modules

# 3. ApacheのMod_Rewriteを有効化
RUN a2enmod rewrite

# 4. ApacheのドキュメントルートをLaravelの「public」フォルダに変更
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. コンテナ内の作業ディレクトリを指定
WORKDIR /var/www/html

# 6. コンテナ内に「application」フォルダの中身をすべてコピー
COPY ./application /var/www/html

# 7. Composerをマルチステージビルドで導入
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 8. 本番環境用のPHPライブラリインストール
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 9. Vue / フロントエンドのビルドを実行
RUN npm ci && npm run build

# 10. Laravelのキャッシュ・ストレージフォルダの権限を変更
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 11. 起動時にAivenのCA証明書を環境変数からファイルに書き出す処理
CMD ["sh", "-c", "php artisan env:decrypt --env=production --force && cp /var/www/html/.env.production /var/www/html/.env && if [ -n \"$DB_SSL_CA\" ]; then echo \"$DB_SSL_CA\" > /var/www/html/ca.pem; fi && php artisan migrate --force && exec apache2-foreground"]
