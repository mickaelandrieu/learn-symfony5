# Live 7 : Introduction aux tests avec PHPUnit et Panther

> Symfony mis à jour vers la version 5.4 à partir de ce live 🚀

## Mise en place de PHPUnit

* `composer require --dev phpunit/phpunit symfony/test-pack`

Puis vérifier dans l'invite de commande :

```
php ./vendor/bin/phpunit

// ET/OU (les 2 fonctionnent)

php ./vendor/bin/simple-phpunit
```

> En savoir plus sur [l'exécutable simple-phpunit](https://symfony.com/doc/5.4/components/phpunit_bridge.html).

Doit produire un résultat équivalent à la sortie console ci-dessous :

```
$ php ./vendor/bin/phpunit
PHPUnit 9.5.11 by Sebastian Bergmann and contributors.

No tests executed!
```

## Création de la base de données de tests

Il faut créer une base de données de test, les tables et les jointures.

* `php bin/console --env=test doctrine:database:create`
* `php bin/console --env=test doctrine:schema:create`

On doit créer des données d'exemple :

* `composer require --dev doctrine/doctrine-fixtures-bundle`

Puis créer des classes de fixtures pour "remplir" la base de données de test :

* `php bin/console make:fixtures`

Ex :

```php
public function load(ObjectManager $manager): void
{
    $user = new User();
    $user->setFirstname('Mickaël');
    $user->setLastname('TestAndrieu');
    $user->setPassword($this->passwordHasher->hashPassword($user, '123456789'));
    $user->setEmail('mickael.andrieu@test.fr');
    $user->setRoles(['ROLE_ADMIN']);

    $manager->persist($user);

    $manager->flush();
}
```

Une fois les fixtures créées :

* `php bin/console --env=test doctrine:fixtures:load`

## Tests classiques (unitaires)

### Exemple : une calculatrice


```php
<?php

namespace App;

/**
 * This class is used to realize some basic calculations.
 * For training purposes only, use bc_math functions instead.
 * @author Mickaël Andrieu <mickael.andrieu@solvolabs.com>
 */
class Calculator
{
    /**
     * @var float The result to display.
     */
    private $result;

    /**
     * Creates the Calculator.
     *
     * @param float $initialValue
     */
    public function __construct($initialValue = 0)
    {
        $this->result = $initialValue;
    }

    /**
     * @param float $number A number.
     */
    public function add($number)
    {
        $this->result = $this->result + $number;
    }

    /**
     * @param float $number A number.
     */
    public function minus($number)
    {
        $this->result = $this->result - $number;
    }

    /**
     * @param float $number A number.
     */
    public function multiply($number)
    {
        $this->result = $this->result * $number;
    }

    /**
     * @param float $number A number.
     */
    public function divideBy($number)
    {
        $this->result = $this->result / $number;
    }

    /**
     * If the object is returned, the result should be displayed.
     *
     * @return string
     */
    public function result()
    {
        return $this->result;
    }
}
```

### Création de la classe de test (TestCase)

* `php bin/console make:test`
* Choisir "TestCase"
* Puis "App\Calculator" (le chemin de la classe)

> [Liste des assertions PHPUnit 9](https://phpunit.readthedocs.io/en/9.5/assertions.html).


## Tests d'intégration (WebTestCase) : les smoke tests

* `php bin/console make:test`
* Choisir "WebTestCase"
* Puis "App\Controller\HomeController" (le chemin de la classe)

### Assertions utiles

* `assertResponseIsSuccessful()` : code 200
* `assertPageTitleSame($expectedTitle)`
* `assertSelectorTextContains($cssSelector, $expression)`

> Lire le trait [DomCrawlerAssertionsTrait](https://github.com/symfony/symfony/blob/5.4/src/Symfony/Bundle/FrameworkBundle/Test/DomCrawlerAssertionsTrait.php).

### Les smoke tests

Très rapides à écrire, ils consistent à seulement vérifier la réponse HTTP après avoir fait une requête HTTP : 200, 301, 302, 403, 404, etc.

```php
// Faire une requête
$client->request('GET', '/whatever');

// cas idéal : >= 200 et <= 300
$this->assertResponseIsSuccessful();
// OU
$this->assertResponseStatusCodeSame(200);

// page qui n'existe pas
$this->assertResponseStatusCodeSame(404);

// page qui est interdite d'accès
$this->assertResponseStatusCodeSame(403);
```

### Exemple de soumission de formulaire

Soumettre un formulaire HTML (non généré par le JavaScript) revient à effectuer
une requête GET ou POST en passant les valeurs reçues par le formulaire.

```php
public function testAddRecipe(): void
{
    $client = static::createClient();
    $client->followRedirects();

    // Être identifié(e) dans les parties sécurisées
    $userRepository = static::getContainer()->get(UserRepository::class);
    $mickael = $userRepository->findOneByEmail('mickael.andrieu@test.fr');
    $client->loginUser($mickael);

    $client->request('GET', '/admin/recipe/new');

    $recipeFile = new UploadedFile(
        __DIR__.'/../../fixtures/recipe.jpg',
        'test_recipe.jpg'
    );

    $client->submitForm('Save', [
        'recipe[title]' => 'Test',
        'recipe[content]' => 'New recipe',
        'recipe[image_file]' => $recipeFile,
    ]);

    $this->assertResponseIsSuccessful();
}
```

> Le code est un peu compliqué car nous gérons le test d'un upload de fichiers
> et l'authentification d'un utilisateur.

## Tests d'interface (PantherTestCase) : intéraction réelle avec le navigateur

Si on fait le choix d'une application avec un front en React/Angular/Vuejs, les formulaires et pages sont générées en JavaScript et Symfony ne peut plus "simuler" le rendu de la page.

C'est pourquoi un logiciel comme Panther a été inventé, il permet de piloter un vrai moteur de navigateur web et donc d'accéder au résultat de l'exécution du JavaScript.

### Installation/Configuration Panther

* `composer require --dev symfony/panther` (puis choix "x")
* `composer require --dev dbrekelmans/bdi`
* `vendor/bin/bdi detect drivers`
* Décommenter l'extension PHPUnit dans le fichier `phpunit.xml.dist`

### Création d'un test avec Panther

* `php bin/console make:test`
* Choisir "PantherTestCase"
* Puis "App\Controller\AdminBeepController" (le chemin de la classe)

#### Problème de port occupé ?

Dans le fichier `.env.test` configurez le port avec une valeur différente de celle qui pose problème :

```
PANTHER_WEB_SERVER_PORT=9081
```