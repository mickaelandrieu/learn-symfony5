# Live 4 : Espace public/privé moderne

## Création du formulaire de Login

* `php bin/console make:controller Login`

### Mise à jour du fichier `security.yaml`

```yaml
security:
    enable_authenticator_manager: true
    password_hashers:
        App\Entity\User:
            algorithm: auto

    providers:
        app_user_provider:
            entity:
                class: App\Entity\User
                property: email
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            lazy: true
            provider: app_user_provider
            form_login:
                login_path: login
                check_path: login
                enable_csrf: true

            logout:
                path: logout
                target: home

    role_hierarchy:
        ROLE_ADMIN: ROLE_USER

    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }

```

## Création du formulaire de création de comptes

* `php bin/console make:registration-form`
