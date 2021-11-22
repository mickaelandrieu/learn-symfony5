<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBeepController extends AbstractController
{
    #[Route('/admin/beep', name: 'beep')]
    public function index(): Response
    {
        return $this->render('beep/index.html.twig', [
            'controller_name' => 'BeepController',
        ]);
    }
}
