# アプリケーション名
お問い合わせフォーム

# 環境構築
## ⓵リポジトリをクローン
以下のコマンドで、Git リポジトリをクローンします。

$ git@github.com:yuki-constructor/coachtech-mock-case1-2.git

## ⓶.env ファイルの作成
以下のコマンドで、 srcディレクトリに移動し、.env.example を .env にコピーします。

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

## ⓷Dockerコンテナのビルドと起動
以下のコマンドで、Dockerコンテナを起動します。

$ docker-compose up --build -d

## ⓸PHPコンテナ内にログイン
以下のコマンドで、PHPコンテナに接続します。

$ docker-compose exec php bash

## ⓹composerのインストール
以下のコマンドで、composerをインストールします。

$ composer install

## ⓺アプリケーションキーの生成
以下のコマンドで、Laravel のアプリケーションキーを生成します。

$ php artisan key:generate

## ⓻シンボリックリンクを設定
以下のコマンドで、画像を公開ディレクトリからアクセス可能にするために、シンボリックリンクを設定します。

$ php artisan storage:link

## ⓼データベースのマイグレーション
以下のコマンドで、データベースをセットアップするために、マイグレーションを実行します。

$ php artisan migrate

## ⑨phpMyAdminの動作確認
http://localhost:8080 にアクセスすることで、phpMyAdminを確認できます。

## ⓾データベースのシーディング
 以下のコマンドで、データベースにサンプルデータを挿入するためにシーディングを実行します。

$ php artisan db:seed

## ⑪アプリケーションの動作確認
http://localhost にアクセスすることで、アプリケーションが動作していることを確認できます。

もし、エラーとなった場合、以下のコマンドでディレクトリ書き込み権限を設定することで改善するか確認してください。

sudo chmod -R 777 src/*　
chmod -R 777 www/.* （PHPコンテナ内に入っている場合は、こちらを実行）


## ⑫Mailpitの設定

### ⑫-1　.env ファイルを開いて、以下の設定を変更します。

MAIL_MAILER=smtp

MAIL_HOST=mailpit

MAIL_PORT=1025

MAIL_USERNAME=null

MAIL_PASSWORD=null

MAIL_ENCRYPTION=null

MAIL_FROM_ADDRESS=noreply@example.com

MAIL_FROM_NAME="${APP_NAME}"


### ⑫-2　config/mail.phpファイルにてMailpitの設定
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


### ⑫-3　Mailpitの動作確認
http://localhost:8025にアクセスすることで、Mailpitを確認できます。


## ⑬Stripeの設定

### ⑬- 1　 Stripeアカウントの作成 
https://dashboard.stripe.com/register　にアクセスし、Stripeアカウントを作成します。
Stripeアカウントを作成した後、以下の２点を行ってください。

１．Stripeのダッシュボードで「コンビニ払い」を有効化
設定（ダッシュボード右上の歯車マーク）＞製品の設定＞決済＞決済手段＞店舗支払い＞コンビニ決済＞有効にする

２．Stripeのダッシュボードで、テスト用の公開可能キー（publishable_key）と秘密キー（secret_key）を確認

### ⑬- 2.　テスト用の公開可能キー（publishable_key）と秘密キー（secret_key）を.envファイルに設定 

 .envファイル

 STRIPE_PUBLIC_KEY=your_test_stripe_public_key 
STRIPE_SECRET_KEY=your_test_stripe_secret_key  

 
以下のコマンドを実行
$ php artisan config:clear 
 $ php artisan cache:clear

 
### ⑬-3　 Stripeパッケージをインストール 

以下のコマンドで、tripe用のパッケージをインストールします。 

 $ composer require stripe/stripe-php 


## ⑭ Fortifyの設定

### ⑭-1　 Fortify パッケージのインストール

以下のコマンドで、 Fortify 用のパッケージをインストールします。

 $composer require laravel/fortify

### ⑭-2　 Fortify の設定ファイルの公開

以下のコマンドで、設定ファイルとリソースを公開します。

 $ php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider" --tag=config

これで、config/fortify.phpという設定ファイルが作成されます。

### ⑭-3　 Fortify のサービスプロバイダを登録

Laravel 11では、Fortifyはデフォルトでサービスプロバイダが登録されています。




# 使用技術(実行環境)
Laravel Framework 11.3.2
PHP 8.2 以上
Mailpit
Fortify
 Stripe 16.4


# ER図


# URL
開発環境：git@github.com:yuki-constructor/coachtech-mock-case1-2.git