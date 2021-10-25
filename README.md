# show database info of mysql server.

## Installation

```bash
mkdir dbinfo
cd dbinfo
git clone https://github.com/ma-sanna/dbinfo-c4.git ./
composer install
```

## setup databace
```bash
vi config/.env
export DATABASE_USERNAME=""
export DATABASE_PASSWORD=""
```

enable .env
config/bootstrap.php line 63
```php
if (!env('APP_NAME') && file_exists(CONFIG . '.env')) {
    $dotenv = new \josegonzalez\Dotenv\Loader([CONFIG . '.env']);
    $dotenv->parse()
        ->putenv()
        ->toEnv()
        ->toServer();
}
```
