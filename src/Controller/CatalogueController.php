<?php

namespace App\Controller;

use App\Entity\Catalogue;
use App\Form\AddToCartType;
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

        return $this->render('catalogue/displayProducts.html.twig', [
            'products' => $products, // Passer les produits au template
        ]);
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

        $form = $this->createForm(AddToCartType::class);

        return $this->render('catalogue/displayProductDetail.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}
