<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProfileController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profile', name: 'app_profile')]
    public function showProfile($id): Response
    {
        $repository = $this->entityManager->getRepository(User::class);
        $profil= $repository->find($id);

        $commande=$profil->getCommandes();
        $panier=$profil->getPanier();

        if(!$profil){
            throw $this->createNotFoundException('vous n\'êtes pas connecté');
        } else {
            return $this->render('profile/index.html.twig',[
                'controller_name' => 'CatalogueItemController',
                'profil'=>$profil,
                'commande'=>$commande,
                'panier'=>$panier,
            ]);
        }
    }
}
