# Live 5 : la gestion des recettes

## Mise en place du CRUD

* `php bin/console make:crud`

### Correction de la connection avec User

```php
<?php
class User {
    /* ... */
    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
>
```

## Gestion de [l'upload d'un fichier](https://symfony.com/doc/current/controller/upload_file.html)



### Activation de l'extension php_fileinfo

Dans le fichier php.ini, décommentez l'extension `fileinfo` et relancez symfony serve.

### Supprimer l'erreur "le fichier manifest.json n'existe pas" (temporaire)

```yaml
# config/packages/assets.yaml
framework:
    assets:
        #json_manifest_path: '%kernel.project_dir%/public/build/manifest.json'
```