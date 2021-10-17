# Live 2 : MakerBundle, création de base de données et débogagge

## Installation du MakerBundle

* `composer require symfony/maker-bundle --dev`

## Mise en place de la base de données

* `php bin/console doctrine:database:create`

## Création de votre premier contrôleur

* `php bin/console make:controller`

## Les outils pour déboguer son application

### La gestion d'erreurs (Error Handler)

Il sera activé en mode `dev`. Pour cela, il faut mettre à jour la valeur de `APP_ENV` à `dev` dans le fichier `.env` (autres valeurs : `prod`, `test`).

### Le Web Profiler

Aussi activé en mode `dev`, va collecter de l'information pendant la construction de l'application.

Informations de requêtes HTTP, base de données, cache, erreurs ...

### Fonctions de déboggage

* `dump()`, `dd()`

> Aussi disponible dans les templates, on y reviendra.

### Activation de APCu

* Installer l'extension PHP selon votre [système d'exploitation](http://pecl.php.net/package/APCu/5.1.21).

* Dans le fichier `php.ini`, ajouter la ligne suivante :

`extension=apcu`
