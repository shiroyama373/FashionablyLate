# FashionablyLate

## 環境構築

### Docker ビルド

1.git clone https://github.com/shiroyama373/FashionablyLate.git
2.docker-compose up -d

＊ MySQL は OS によって起動しない場合があります。その場合は、docker-compose.yml ファイルを編集し、それぞれの PC に合わせて調整してください。

### Laravel 環境構築

1.  docker-compose exec php composer install
2.  composer install
3.  .env.example をコピーして.env ファイルを作成し、環境変数を変更<br>
    ※.env ファイルの DB_DATABASE、DB_USERNAME、DB_PASSWORD の値を docker-compose.yml に記載の値に変更
4.  php artisan key:generate
5,  php artisan migrate
6.  php artisan db:seed<br>
    ※ログインの際必要なデータは database\seeders\UsersTableSeeder.php に記載
7.  php artisan storage:link


## 使用技術

・PHP 8.x
・Laravel 9.x
・MySQL 8.x
・mailhog（開発用メール確認ツール
•phpMyAdmin（MySQL 管理ツール）



URL
・開発環境：http://localhost
・phpMyAdminhttp://localhost:8080


## ER図

![ER図](src/images/er_diagram.png)