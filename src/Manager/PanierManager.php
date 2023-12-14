<?php

namespace App\Manager;

use App\Entity\Commande;
use App\Factory\CommandeFactory;
use App\Storage\PanierSessionStorage;
use Doctrine\ORM\EntityManagerInterface;

class PanierManager
{
    private PanierSessionStorage $panierSessionStorage;
    private CommandeFactory $panierFactory;
    private EntityManagerInterface $entityManager;

    public function __construct(
        PanierSessionStorage $panierSessionStorage,
        CommandeFactory $panierFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->panierSessionStorage = $panierSessionStorage;
        $this->panierFactory = $panierFactory;
        $this->entityManager = $entityManager;
    }

    public function getCurrentPanier(): ?Commande
    {
        $panier = $this->panierSessionStorage->getPanier();

        if (!$panier) {
            $panier = $this->panierFactory->create();
            $this->save($panier);
        }

        return $panier;
    }

    public function save(Commande $panier): void
    {
        $this->entityManager->persist($panier);
        $this->entityManager->flush();
        $this->panierSessionStorage->setPanier($panier);
    }
}
