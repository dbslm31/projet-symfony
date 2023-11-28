<?php

namespace App\Entity;

use App\Repository\OrderItemsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemsRepository::class)]
class OrderItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    private ?Catalogue $produit = null;

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


}
