<?php

namespace App\Controller;

use App\Entity\Catalogue;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/catalogue', name: 'app_catalogue')]
    public function displayProducts(): Response
    {
        // Récupérer le Repository Doctrine pour l'entité Catalogue
        $repository = $this->entityManager->getRepository(Catalogue::class);

        // Effectuer une requête pour récupérer les produits
        $products = $repository->findAll();

        // Formater les données pour ne conserver que le nom et le prix
        $formattedProducts = [];
        foreach ($products as $product) {
            $formattedProducts[] = [
                'nom' => $product->getNom(),
                'prix' => $product->getPrix(),
            ];
        }

        // Vous pouvez ensuite passer $formattedProducts à votre template ou le retourner directement en JSON, par exemple
        return $this->json($formattedProducts);
    }
}
