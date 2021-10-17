# Live 1 : Pré-requis et installation

## Pré-requis

* [PHP 8](https://www.colinodell.com/blog/202011/how-install-php-80)
* [MySQL](https://dev.mysql.com/doc/mysql-installation-excerpt/8.0/en/)
* [Composer](https://getcomposer.org/)
* [Visual Studio Code](https://code.visualstudio.com/)
* [BeepKeeper Studio](https://www.beekeeperstudio.io/)
* [Symfony CLI](https://symfony.com/download)
* [npm et nodejs](https://nodejs.org/en/download/)

### Extensions PHP

Activez ces extensions dans le fichier php.ini :

* `curl`
* `intl`
* `mbstring`
* `mysqli`
* `openssl`
* `pdo_mysql`
* `pdo_pgsql`
* `pdo_sqlite`
* `sodium`
* `sqlite3`
* `xsl`

## Création du projet

### Téléchargement des ressources

La commande suivante va télécharger l'application Symfony et toutes les dépendances :

* `symfony new <nom-app> --full`

Ex: symfony new sf-app --full

### Activation du HTTPS

L'instruction suivante permet d'activer le HTTPS sur votre poste de développement :

* `symfony server:ca:install`

### Configuration d'un nom de domaine (en mode dev)

Selon votre système d'exploitation, configurez [le proxy](https://symfony.com/doc/current/setup/symfony_server.html#setting-up-the-local-proxy) :

* `symfony proxy:start` (ne pas fermer, ni stopper la commande)
* `cd sf-app` (A l'intérieur du projet, dans le dossier racine)
* `symfony proxy:domain:attach <domaine>`

Ex :  symfony proxy:domain:attach sf

### Démarrage du serveur web

* `cd sf-app`
* `symfony serve`

Le projet sera alors disponible à l'adresse suivante après lancement du serveur web : [https://sf.wip](https://sf.wip).

### Installation du package Encore

* `cd sf-app`
* `composer require symfony/webpack-encore-bundle`
* `npm install`
