<?php

namespace App\Controller;

use App\Entity\Catalogue;
use App\Form\AddNewProductFormType;
use App\Form\UpdateProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CatalogueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
                'controller_name' => 'CatalogueItemController',
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
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManagerInterface->persist($product);
            // actually executes the queries (i.e. the INSERT query)
            $entityManagerInterface->flush();
            return new Response('Saved new product with id '.$product->getId());
            };
        return $this->render('catalogue/add_product.html.twig',[
            'form'=>$form,]);
        }

        #[Route('/cataloguedelete/{id}', name: 'app_catalogue_delete')]
        public function deleteProduct($id): Response
        {
            $em= $this->entityManager->getRepository(Catalogue::class);
            $product=$em->find($id);
            if (!$product){
                throw $this->createNotFoundException('Produit inexistant');
            } else{
            $em= $this->entityManager->remove($product);
            $em= $this->entityManager->flush();
            return $this->redirect('/catalogue');
            }
        }

        #[Route('/catalogueupdate/{id}', name:'app_catalogue_update')]
        public function updateProduct($id, Request $request, CatalogueRepository $catalogueRepo, EntityManagerInterface $entityManagerInterface): Response{
            $redirect = new RedirectResponse('app_catalogue');
            $productbase = $catalogueRepo->find($id);
            $product = new Catalogue();
            $form = $this->createForm(UpdateProductFormType::class, $productbase);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                // actually executes the queries (i.e. the INSERT query)
                $entityManagerInterface->flush();
                return $this->redirect('/catalogue');
                };
            return $this->render('catalogue/add_product.html.twig',[
                'product'=>$productbase,
                'form'=>$form,
            ]);
            }
    }
