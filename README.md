<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

## Description:

Invento est une application Web de gestion et de reporting de stock qui offre des formes et de tableaux et de graphiques pour améliorer la gestion commerciale. 
Avec des règles de contraintes très	 fortes, L'application doit être fiable et offrir une réponse rapide aux besoins de l'utilisateur. Elle comprend des fonctionnalités telles que la gestion de clients, fournisseurs, produits, achats, ventes, stocks, factures, crédits, paiements, etc.

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


## railway Configuration
```
APP_NAME=Laravel
APP_ENV=production
APP_KEY=base64:ZGjxxddTs8e2l/Nv6ZLuodpcuyDLKIJiDLdbO0KeTEU=
APP_DEBUG=false
APP_URL=stock-production-c34d.up.railway.app
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
DB_CONNECTION=mysql
DB_HOST=containers-us-west-178.railway.app
DB_PORT=7157
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=r4SqTyBzvE0IHJZBKn7y
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
MEMCACHED_HOST=127.0.0.1
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME=${APP_NAME}
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1
VITE_PUSHER_APP_KEY=${PUSHER_APP_KEY}
VITE_PUSHER_HOST=${PUSHER_HOST}
VITE_PUSHER_PORT=${PUSHER_PORT}
VITE_PUSHER_SCHEME=${PUSHER_SCHEME}
VITE_PUSHER_APP_CLUSTER=${PUSHER_APP_CLUSTER}
NIXPACKS_BUILD_CMD=npm run build && php artisan migrate --seed --force && php artisan view:cache && php artisan route:cache && php artisan config:cache
NIXPACKS_INSTALL_CMD=mkdir -p /var/log/nginx && mkdir -p /var/cache/nginx && composer install --optimize-autoloader && npm ci
```
