<?php

namespace App\Controller;
use App\Exception\ClientNotFoundException;
use App\Form\CartType;
use App\Manager\PanierManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CartController
 * @package App\Controller
 */
class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(PanierManager $panierManager, Request $request): Response
    {
        try {
            $panier = $panierManager->getCurrentPanier();
        } catch (ClientNotFoundException $e) {
            // Redirection vers la page de connexion
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(CartType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $panier->setUpdatedAt(new \DateTime());
            $panierManager->save($panier);

            return $this->redirectToRoute('app_panier'); // Assurez-vous que c'est le nom correct de la route
        }

        return $this->render('cart/index.html.twig', [
            'panier' => $panier,
            'form' => $form->createView()
        ]);
    }
}