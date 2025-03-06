# ベースイメージの指定
FROM nginx:1.20-alpine

ENV TZ Asia/Tokyo

# 作成した設定ファイルをコンテナ内にコピー
COPY ./docker/web/default.conf /etc/nginx/conf.d/default.conf