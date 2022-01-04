# Live 8 : Outils de contrôle de qualité de code (PHP)

## PHP-CS-Fixer

### Installation

```
mkdir tools/php-cs-fixer
composer require --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer --dev
```

### Utilisation

```bash
# Reformattes le code en suivant les standards !
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix .

# Ou affiche seulement les correctifs, sans les appliquer
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix . --dry-run

# Autre option bien utile : s'arrête directement dès la première erreur rencontrée
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix . --dry-run --stop-on-violation
```

## PHPStan

### Installation

```
composer require phpstan/phpstan --dev
```

## (Bonus) Configurer Composer

## (Bonus) Configurer un hook git

