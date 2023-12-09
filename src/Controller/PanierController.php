<?php



namespace App\Controller;

use App\Entity\Catalogue;
use App\Entity\Panier;
use App\Entity\OrderItems;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier/ajouter/{produit}', name: 'ajouter_au_panier')]
    public function ajouterAuPanier(Catalogue $produit): Response
    {
        // Récupérer l'utilisateur actuel (assurez-vous que l'utilisateur est connecté)
        $user = $this->getUser();

        // Récupérer ou créer le panier de l'utilisateur
        $panier = $user->getPanier();
        if (!$panier) {
            $panier = new Panier();
            $panier->setClient($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($panier);
            $entityManager->flush();
        }

        // Ajouter le produit au panier
        $orderItem = new OrderItems();
        $orderItem->setProduit($produit);
        $panier->addOrderItem($orderItem);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($orderItem);
        $entityManager->flush();

        return $this->redirectToRoute('page_du_produit', ['id' => $produit->getId()]);
    }

    #[Route('/panier', name: 'panier')]
    public function voirPanier(): Response
    {
        // Récupérer l'utilisateur actuel (assurez-vous que l'utilisateur est connecté)
        $user = $this->getUser();

        // Récupérer le panier de l'utilisateur
        $panier = $user->getPanier();

        return $this->render('panier/voir.html.twig', [
            'panier' => $panier,
        ]);
    }

    // Ajoutez d'autres actions du panier (supprimer un produit, passer à la caisse, etc.) selon vos besoins.
}

