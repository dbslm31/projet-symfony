<?php
<<<<<<< HEAD

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MagasinController extends AbstractController
{
    #[Route('/magasin', name: 'app_magasin')]
    public function index(): Response
    {
        return $this->render('magasin/index.html.twig', [
            'controller_name' => 'MagasinController',
        ]);
    }
}
=======

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MagasinController extends AbstractController
{
    #[Route('/magasin', name: 'app_magasin')]
    public function index(): Response
    {
        return $this->render('magasin/index.html.twig', [
            'controller_name' => 'MagasinController',
        ]);
    }
}
>>>>>>> d09e25a0182347aa5907d9bab3eed9648fd262ac
