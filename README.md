# mysqlデータベース情報を表示する
必要なモノ  
CakePHP4 が動作するPHPとmysql  

## Installation
```bash
mkdir dbinfo
cd dbinfo
git clone https://github.com/ma-sanna/dbinfo-c4.git ./
composer install
```

## データベース接続情報を設定
```bash
vi config/.env
export DATABASE_USERNAME="your_id"
export DATABASE_PASSWORD="your_password"
```
デフォルトmysqlデータベースになっているので適宜 app_local.php で変更

.env を有効にする  
config/bootstrap.php 63行付近
```php
if (!env('APP_NAME') && file_exists(CONFIG . '.env')) {
    $dotenv = new \josegonzalez\Dotenv\Loader([CONFIG . '.env']);
    $dotenv->parse()
        ->putenv()
        ->toEnv()
        ->toServer();
}

場合によっては
        ->putenv(true)
とするが、条件確認中
```

## httpsが有効になっているので無効化する
webroot/index.php 21行付近
```
// $_SERVER['HTTPS'] = 'on';
```

## 起動
```
bin/cake server -p 8765
```

## bake
bakeしていくとテーブル一覧の viewから内容を表示できる
```
bin/cake bake all user
```
## 画面サンプル
table list  
(https://user-images.githubusercontent.com/83142803/138778492-f649434d-0c4e-4f79-878e-6fbe28168aea.png)
columns   
(https://user-images.githubusercontent.com/83142803/138778504-9d1ac53b-cff6-4ed1-b9d3-8e1656c81c27.png)
baked page  
(https://user-images.githubusercontent.com/83142803/138778518-facaa20f-2db3-450f-9bce-75436a177884.png)


