# 環境構築
## 前提
ローカル環境に以下をインストールしておくこと
* node
* npm

## 構築手順
本プロジェクトのディレクトリ直下に移動した上で、セットアップ用のコマンドを実行します
```shell
cd {任意のフォルダ}/baseball-game-management-server
make setup
```

<details>
<summary>補足情報(環境構築の詳細)</summary>

* 本アプリケーションはdockerコンテナを利用しています。まずは、コンテナのビルドを行います。
```shell
docker compose up -d
docker compose build
```

* パッケージ管理ツールを利用して利用パッケージをインストールします。
```shell
docker compose exec baseball-game-management-app composer install
docker compose exec baseball-game-management-app npm ci
```

* データベースのマイグレーション、データ投入を行います
```shell
docker compose exec baseball-game-management-app php artisan migrate:fresh --seed
docker compose exec baseball-game-management-app php artisan db:seed
```

* アプリケーションキーを生成します
```shell
docker compose exec baseball-game-management-app php artisan key:generate
```

</details>

# 環境情報
本アプリケーションでは3つのコンテナを利用した3層アーキテクチャを採用しています。
コンテナ名は以下の通りです。
* Webサーバ: web
* アプリケーションサーバ: baseball-game-management-app
* DBサーバ: baseball-game-management-db


## DBサーバ
DBサーバはMySQLを利用しています。
DBサーバのコンテナに入り、MySQLを利用するには以下のコマンドを実行してください。
```bash
docker compose exec db mysql -u root -ppassword
```

# ローカル開発tips
## 管理画面用ユーザ
アプリケーションサーバ(baseball-game-management-app)に入り、シーダーを実行すると管理画面用ユーザがuserテーブルに登録されます。
```bash
docker compose exec baseball-game-management-app bash
[コンテナ内で実行] php artisan migrate
[コンテナ内で実行] php artisan db:seed
```

## 管理画面のログイン方法
* `http://localhost:8080/admin/login` にアクセスし、以下のユーザ情報を入力してログインする
  * メールアドレス：`test@test.com`
  * パスワード : `password1234`

