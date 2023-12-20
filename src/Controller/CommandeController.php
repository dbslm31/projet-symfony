<?php

namespace App\Controller;

use app\entity\Catalogue;
use App\Entity\Commande;
use App\Entity\Panier;
use App\Repository\CatalogueRepository;
use Doctrine\Tests\Models\Enums\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CommandeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        //$this->entityManager = $entityManager;
    }

    #[Route('/commande', name: 'app_commande')]
    public function buyarticle(CatalogueRepository $cataloguerepo): Response
    {
        $articles = $cataloguerepo->findAll();


        return $this->render('commande/index.html.twig', ['articles'=>$articles]);
    }


}
