<<<<<<< HEAD
<?php

namespace App\Controller;

use App\Model\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{

    #[Route('/panier', name: 'app_panier')]
    public function index(): Response
        {
            return $this->render('panier/index.html.twig', [
                'controller_name' => 'PanierController',
            ]);
        }
}
=======
<?php

namespace App\Controller;

use App\Model\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{

    #[Route('/panier', name: 'app_panier')]
    public function index(): Response
        {
            return $this->render('panier/index.html.twig', [
                'controller_name' => 'PanierController',
            ]);
        }
}
>>>>>>> d09e25a0182347aa5907d9bab3eed9648fd262ac
