<?php

namespace App\Storage;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierSessionStorage
{
    private RequestStack $requestStack;
    private CommandeRepository $panierRepository;

    public const PANIER_KEY_NAME = 'panier_id';

    public function __construct(RequestStack $requestStack, CommandeRepository $panierRepository)
    {
        $this->requestStack = $requestStack;
        $this->panierRepository = $panierRepository;
    }

    public function getPanier(): ?Commande
    {
        return $this->panierRepository->findOneBy([
            'id' => $this->getPanierId(),
            'status' => Commande::STATUT_PANIER
        ]);
    }

    public function setPanier(Commande $panier): void
    {
        $this->getSession()->set(self::PANIER_KEY_NAME, $panier->getId());
    }

    private function getPanierId(): ?int
    {
        return $this->getSession()->get(self::PANIER_KEY_NAME);
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}
