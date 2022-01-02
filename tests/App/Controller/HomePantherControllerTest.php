<?php

namespace App\Tests\App\Controller;

use Symfony\Component\Panther\PantherTestCase;

class HomePantherControllerTest extends PantherTestCase
{
    public function testSomething(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        $this->assertPageTitleContains('Bienvenue sur votre site !');
    }
}
