# アプリケーション名

coachtechフリマ

# 環境構築

## ⓵ リポジトリをクローン

以下のコマンドで、Git リポジトリをクローンします。

$ git@github.com:yuki-constructor/coachtech-mock-case1-2.git

## ⓶.env ファイルの作成

以下のコマンドで、 src ディレクトリに移動し、.env.example を .env にコピーします。

$ cd src/

$ cp .env.example .env


.env ファイルを開いて、以下の設定を変更します。


APP_TIMEZONE=Asia/Tokyo

APP_LOCALE=ja

DB_CONNECTION=mysql

DB_HOST=mysql

DB_PORT=3306

DDB_DATABASE=laravel_db

DB_USERNAME=laravel_user

DB_PASSWORD=laravel_pass

## ⓷Docker コンテナのビルドと起動

以下のコマンドで、Docker コンテナを起動します。

$ docker-compose up --build -d

## ⓸PHP コンテナ内にログイン

以下のコマンドで、PHP コンテナに接続します。

$ docker-compose exec php bash

## ⓹composer のインストール

以下のコマンドで、composer をインストールします。

$ composer install

## ⓺ アプリケーションキーの生成

以下のコマンドで、Laravel のアプリケーションキーを生成します。

$ php artisan key:generate

## ⓻ シンボリックリンクを設定

以下のコマンドで、画像を公開ディレクトリからアクセス可能にするために、シンボリックリンクを設定します。

$ php artisan storage:link

## ⓼ データベースのマイグレーション

以下のコマンドで、データベースをセットアップするために、マイグレーションを実行します。

$ php artisan migrate

## ⑨phpMyAdmin の動作確認

http://localhost:8080 にアクセスすることで、phpMyAdmin を確認できます。

## ⓾ データベースのシーディング

以下のコマンドで、データベースにサンプルデータを挿入するためにシーディングを実行します。

$ php artisan db:seed

## ⑪ アプリケーションの動作確認

http://localhost にアクセスすることで、アプリケーションが動作していることを確認できます。

もし、エラーとなった場合、以下のコマンドでディレクトリ書き込み権限を設定することで改善するか確認してください。

sudo chmod -R 777 src/_　
chmod -R 777 www/._ （PHP コンテナ内に入っている場合は、こちらを実行）

## ⑫Mailpit の設定

### ⑫-1. 　.env ファイルを開いて、以下の設定を変更します。

MAIL_MAILER=smtp

MAIL_HOST=mailpit

MAIL_PORT=1025

MAIL_USERNAME=null

MAIL_PASSWORD=null

MAIL_ENCRYPTION=null

MAIL_FROM_ADDRESS=noreply@example.com

MAIL_FROM_NAME="${APP_NAME}"

### ⑫-2. 　 config/mail.php ファイルにて Mailpit の設定

以下のように設定を確認・修正してください。

return [

    'default' => env('MAIL_MAILER', 'smtp'),

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 1025),
            'encryption' => env('MAIL_ENCRYPTION', null),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
        ],
    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Laravel'),
    ],

    'markdown' => [
        'theme' => 'default',

        'paths' => [
             resource_path('views/emails'), // カスタムビュー用ディレクトリ
        resource_path('views/vendor/mail'), // デフォルトのオーバーライド用
          ],

],

];

以下のコマンドを実行  
$ php artisan config:clear  
$ php artisan cache:clear

### ⑫-3. 　 Mailpit の動作確認

http://localhost:8025 にアクセスすることで、Mailpit を確認できます。

## ⑬Stripe の設定

### ⑬- 1. 　 Stripe アカウントの作成

<https://dashboard.stripe.com/register>　にアクセスし、Stripe アカウントを作成します。  
Stripe アカウントを作成した後、以下の２点を行ってください。

１．Stripe のダッシュボードで「コンビニ払い」を有効化
設定（ダッシュボード右上の歯車マーク）＞製品の設定＞決済＞決済手段＞店舗支払い＞コンビニ決済＞有効にする

２．Stripe のダッシュボードで、テスト用の公開可能キー（publishable_key）と秘密キー（secret_key）を確認

### ⑬- 2.　テスト用の公開可能キー（publishable_key）と秘密キー（secret_key）を.env ファイルに設定

.env ファイル

STRIPE_PUBLIC_KEY=your_test_stripe_public_key
STRIPE_SECRET_KEY=your_test_stripe_secret_key

以下のコマンドを実行  
$ php artisan config:clear  
$ php artisan cache:clear  

### ⑬-3. 　 Stripe パッケージをインストール

以下のコマンドで、tripe 用のパッケージをインストールします。

$ composer require stripe/stripe-php

## ⑭ Fortify の設定

### ⑭-1. 　 Fortify パッケージのインストール

以下のコマンドで、 Fortify 用のパッケージをインストールします。

$composer require laravel/fortify

### ⑭-2. 　 Fortify の設定ファイルの公開

以下のコマンドで、設定ファイルとリソースを公開します。

$ php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider" --tag=config

これで、config/fortify.php という設定ファイルが作成されます。

### ⑭-3. 　 Fortify のサービスプロバイダを登録

Laravel 11 では、Fortify はデフォルトでサービスプロバイダが登録されています。

# 使用技術(実行環境)

Laravel Framework 11.3.2  
PHP 8.2 以上  
Mailpit  
Fortify  
Stripe 16.4  

# ER 図

<mxfile><diagram id="vFQ7NS8Wbspd5YqO8UGM" name="ページ1">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</diagram></mxfile>

# URL

開発環境：[git@github.com:yuki-constructor/coachtech-mock-case1-2.git](https://github.com/yuki-constructor/coachtech-mock-case1-2.git)
