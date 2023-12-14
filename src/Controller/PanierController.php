<?php



namespace App\Controller;

use App\Entity\Catalogue;
use App\Entity\Panier;
use App\Entity\OrderItems;
use App\Repository\PanierRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{


    #[Route('/panier', name: 'app_panier')]
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

    public function ajouterAuPanier(int $id, PanierRepository $panierRepository, ManagerRegistry $managerRegistry): Response
    {
        // Récupère l'utilisateur actuellement connecté (peut varier en fonction de ton système d'authentification)
        $user = $this->getUser();

        // Vérifie si l'utilisateur a un panier associé
        if ($user->getPanier() === null) {
            // Crée un nouveau panier vide
            $panier = $panierRepository->createEmptyPanier();
            // Associe le panier à l'utilisateur
            $panier->setClient($user);
            // Enregistre le panier en base de données
            $entityManager = $managerRegistry->getManager();
            $entityManager->persist($panier);
            $entityManager->flush();
        } else {
            // Utilise le panier existant de l'utilisateur
            $panier = $user->getPanier();
        }

        // À ce stade, tu as un panier valide (nouveau ou existant) associé à l'utilisateur

        // ... La suite de ton code pour ajouter l'élément de commande au panier

        return $this->redirectToRoute('app_panier'); // Redirige où tu veux après avoir ajouté au panier
    }





    // Ajoutez d'autres actions du panier (supprimer un produit, passer à la caisse, etc.) selon vos besoins.
}

