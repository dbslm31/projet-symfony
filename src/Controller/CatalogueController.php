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

        $repository = $this->entityManager->getRepository(Catalogue::class);

        $products = $repository->findAll();

        if (!$products) {
            throw $this->createNotFoundException('Oups ! Le catalogue est vide');
        }

        $formattedProducts = [];
        foreach ($products as $product) {
            $formattedProducts[] = [
                'nom' => $product->getNom(),
                'prix' => $product->getPrix(),
                'image' => $product->getImage(),
            ];
        }


        return $this->json($formattedProducts);
    }

    #[Route('/catalogue/{id}', name: 'app_product_detail')]
    public function displayProductDetail($id): Response
    {

        $repository = $this->entityManager->getRepository(Catalogue::class);

        // Find product  by id
        $product = $repository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit avec l\'ID ' . $id . ' n\'existe pas.');
        }


        return $this->json([
            'nom' => $product->getNom(),
            'description' => $product->getDescription(),
            'prix' => $product->getPrix(),
            'image' => $product->getImage(),
        ]);
    }
}
