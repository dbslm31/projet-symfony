<?php

namespace App\Entity;

use App\Repository\OrderItemsRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemsRepository::class)]
class OrderItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Catalogue::class)]
    private ?Catalogue $produit = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(1)]
    private int $quantity;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?float $total = null;

    //#[ORM\ManyToOne(inversedBy: 'orderItems')]
    //private ?Panier $panier = null;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'orderItems')]
    private ?Commande $commandeRef = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Catalogue
    {
        return $this->produit;
    }

    public function setProduit(?Catalogue $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCommandeRef(): ?Commande
    {
        return $this->commandeRef;
    }

    public function setCommandeRef(?Commande $commandeRef): self
    {
        $this->commandeRef = $commandeRef;

        return $this;
    }

    /**
     * Tests if the given item given corresponds to the same order item.
     *
     * @param OrderItems $orderItem
     *
     * @return bool
     */
    public function equals(OrderItems $orderItem): bool
    {
        return $this->getProduit()->getId() === $orderItem->getProduit()->getId();
    }

    /**
     * Calculates the item total.
     *
     * @return float|int
     */
    public function getTotal(): float|int
    {
        return $this->getProduit()->getPrix() * $this->getQuantity();
    }


}
