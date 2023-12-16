<?php

namespace App\Controller;

use App\Entity\Catalogue;
use App\Form\AddNewProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CatalogueController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/catalogue', name: 'app_catalogue')]
    public function displayProducts(Request $request): Response
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

            return $this->render('catalogue/index.html.twig',[
                'controller_name' => 'CatalogueController',
                'products'=>$products,
                //'addProductFrom' =>$form->createView(),
            ]);
        //return $this->json($formattedProducts);
    }

    #[Route('/catalogue/{id}', name: 'app_product_detail')]
    public function displayProductDetail($id): Response
    {

        $repository = $this->entityManager->getRepository(Catalogue::class);

        // Find product  by id
        $product = $repository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit avec l\'ID ' . $id . ' n\'existe pas.');
        } else {
            return $this->render('catalogue/index.html.twig',[
                'controller_name' => 'CatalogueController',
                'product'=>$product,
            ]);
        };


        /*return $this->json([
            'nom' => $product->getNom(),
            'description' => $product->getDescription(),
            'prix' => $product->getPrix(),
            'image' => $product->getImage(),
        ]);*/
    }

    #[Route("/catalogueaddto", name:'app_catalogue_add')]
    public function addCatalogue(Request $request, EntityManagerInterface $entityManagerInterface):Response{

        $product = new Catalogue();
        $form = $this->createForm(AddNewProductFormType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $product= $form->getData();
            $product->setNom($product['nom']);
            $product->setDescription($product['description']);
            $product->setCategory($product['category']);
            $product->setSubcategory($product['subcategory']);
            $product->setPrix($product['prix']);
            $product->setPromo($product['promo']);
            $product->setStock($product['stock']);

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManagerInterface->persist($product);

            // actually executes the queries (i.e. the INSERT query)
            $entityManagerInterface->flush();

            return new Response('Saved new product with id '.$product->getId());
            };
        return $this->render('catalogue/add_product.html.twig',[
            'form'=>$form,]);
        }
}
