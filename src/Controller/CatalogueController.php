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
                'image' => $product->getImage(),
            ];
        }

        // Vous pouvez ensuite passer $formattedProducts à votre template ou le retourner directement en JSON, par exemple
        return $this->json($formattedProducts);
    }

    #[Route('/catalogue/{id}', name: 'app_product_detail')]
    public function displayProductDetail($id): Response
    {
        // Récupérer le Repository Doctrine pour l'entité Catalogue
        $repository = $this->entityManager->getRepository(Catalogue::class);

        // Rechercher le produit par ID
        $product = $repository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit avec l\'ID ' . $id . ' n\'existe pas.');
        }

        // Vous pouvez ensuite passer les détails du produit à votre template ou le retourner directement en JSON, par exemple
        return $this->json([
            'nom' => $product->getNom(),
            'description' => $product->getDescription(),
            'prix' => $product->getPrix(),
            'image' => $product->getImage(),
        ]);
    }
}
