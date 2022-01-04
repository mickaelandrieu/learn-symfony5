<?php

namespace App\Tests\App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RecipeControllerTest extends WebTestCase
{
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
}
