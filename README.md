<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

## Description:

Ce projet consiste en une application Web de gestion et de reporting de stock qui offre une grande quantité de données synthétisées sous forme de tableaux et de graphiques pour améliorer la gestion commerciale. L'application doit être fiable et offrir une réponse rapide aux besoins de l'utilisateur. Elle comprend des fonctionnalités telles que la gestion de clients, fournisseurs, produits, achats, ventes, stocks, factures, crédits, paiements, etc.

## Configuration:

1.   [XAMPP](https://www.apachefriends.org/download.html) (PHP `^8.1`)
2.   [Composer](https://getcomposer.org/download/)
3.   [Node.js](https://nodejs.org/en/download/)

Clonez le référentiel :

```
git clone https://github.com/mehdidhammou/stock
```

Accédez au répertoire du projet :

```
cd stock
```

Installez les dépendances :

```
composer install
npm install
```

Créez une copie du fichier d'exemple de l'environnement:

- Linux

```
cp .env.example .env
```

- Windows

```
copy .env.example .env
```

Générez une clé d'application :

```
php artisan key:generate
```

Configurez la connexion à la base de données dans le fichier `.env` :

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stock_db
DB_USERNAME=root
DB_PASSWORD=
```

Exécutez les migrations de base de données :

```
php artisan migrate:fresh --seed
```

## Utilisation

Pour démarrer le serveur de développement, exécutez la commande suivante :

```
npm run dev
php artisan serve
```

Vous pouvez alors accéder à l'application à [ localhost ](http://localhost:8000)

## Licence

Ce projet est sous licence MIT.

## Auteurs

Créateurs et mainteneurs

-   [mehdidhammou](https://github.com/mehdidhammou)
-   [walidksb](https://github.com/walidksb)
