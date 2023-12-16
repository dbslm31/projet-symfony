<?php

namespace App\Manager;
use App\Exception\ClientNotFoundException;
use App\Entity\Commande;
use App\Entity\User;
use App\Repository\RoleRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use App\Factory\CommandeFactory;
use App\Storage\PanierSessionStorage;
use Doctrine\ORM\EntityManagerInterface;

class PanierManager
{
    private RoleRepository $roleRepository;
    private PanierSessionStorage $panierSessionStorage;
    private CommandeFactory $panierFactory;
    private EntityManagerInterface $entityManager;

    public function __construct(
        PanierSessionStorage $panierSessionStorage,
        CommandeFactory $panierFactory,
        EntityManagerInterface $entityManager,
        RoleRepository $roleRepository
    ) {
        $this->panierSessionStorage = $panierSessionStorage;
        $this->panierFactory = $panierFactory;
        $this->entityManager = $entityManager;
        $this->roleRepository = $roleRepository;
    }

    public function getCurrentPanier(): ?Commande
    {
        $panier = $this->panierSessionStorage->getPanier();

        if (!$panier) {
            $panier = $this->panierFactory->create();

            // Créer un client invité si aucun client n'est associé au panier
            if ($panier->getClient() === null) {
                $clientInvite = User::createGuest($this->roleRepository); // Méthode statique pour créer un client invité
                $panier->setClient($clientInvite);
                $this->entityManager->persist($clientInvite); // Persister le client invité si nécessaire
            }

            $this->entityManager->persist($panier);
            $this->entityManager->flush();
        }

        return $panier;
    }

    public function save(Commande $panier): void
    {
        if ($panier->getClient() === null) {
            throw new ClientNotFoundException();
        }

        if ($panier->getPrix() === null) {
            $panier->setPrix(0); // Ou toute autre logique pour définir le prix
        }

        $this->entityManager->persist($panier);
        $this->entityManager->flush();
        $this->panierSessionStorage->setPanier($panier);
    }
}

