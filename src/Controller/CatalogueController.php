<?php

namespace App\Controller;

use App\Entity\Catalogue;
use App\Form\AddToCartType;
use App\Manager\PanierManager;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    private EntityManagerInterface $entityManager;

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
    public function displayProductDetail(Catalogue $product, Request $request, PanierManager $panierManager): Response
    {
        $form = $this->createForm(AddToCartType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $item->setProduit($product);

            $panier = $panierManager->getCurrentPanier();
            $panier->addOrderItem($item);
            $this->entityManager->persist($panier);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_product_detail', ['id' => $product->getId()]);
        }

        return $this->render('catalogue/displayProductDetail.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}
