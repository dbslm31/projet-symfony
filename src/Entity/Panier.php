<?php

namespace App\Entity;

use App\Repository\PanierRepository;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'panier', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $client = null;

    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: OrderItems::class, cascade: ['persist', 'remove'])]
    private Collection $orderItems;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?float $total = null;


    /* #[ORM\Column(length: 9999)]
     private ?string $produits = null;*/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(User $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }

    /*public function getProduits(): ?string
    {
        return $this->produits;
    }

    public function setProduits(string $produits): static
    {
        $this->produits = $produits;

        return $this;
    }*/

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }


    /**
     * @return Collection<OrderItems>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItems $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setPanier($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItems $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getPanier() === $this) {
                $orderItem->setPanier(null);
            }
        }

        return $this;
    }

}