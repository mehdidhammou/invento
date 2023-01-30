<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="public/logo.svg" width="500" alt="Laravel Logo">
    </a>
</p>

## Configuration:

1.   [XAMPP](https://www.apachefriends.org/download.html) (PHP `^8.1`)
2.   [Composer](https://getcomposer.org/download/)
3.   [Node.js](https://nodejs.org/en/download/)

Clone the repo :

```
git clone https://github.com/mehdidhammou/invento
```

cd to the project :

```
cd invento
```

install all dependencies :

```
composer install
npm install
```

create a local .env file :

- Linux

```
cp .env.example .env
```

- Windows

```
copy .env.example .env
```

generate the app key :

```
php artisan key:generate
```

Configure the database connection in `.env` :

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invento_db
DB_USERNAME=root
DB_PASSWORD=
```

run the migrations :

```
php artisan migrate:fresh --seed
```

## Utilisation

run the dev servers :

```
npm run dev
php artisan serve
```

## Licence

Ce projet est sous licence MIT.

## Auteurs

creators and maintainers

-   [mehdidhammou](https://github.com/mehdidhammou)
-   [walidksb](https://github.com/walidksb)
