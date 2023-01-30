<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

## Description:

Invento is a web inventory management and reporting application that offers forms and charts and graphs to improve businesses improve management.
With very strong constraint rules, the application offers a rapid response to the user's needs. It includes functionalities such as the management of customers, suppliers, products, purchases, sales, stocks, invoices, credits, payments, etc.

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
