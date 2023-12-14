<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //USERID
    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $client = null;

    //ORDERITEMS
    #[ORM\OneToMany(mappedBy: 'commandeRef', targetEntity: OrderItems::class, cascade: ['persist', 'remove'])]
    private Collection $orderItems;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $commande = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $envoi = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $livraison = null;

    //STATUS
    #[ORM\Column(length: 255)]
    private ?string $statut = self::STATUT_PANIER;

    /**
     * An order that is in progress, not placed yet.
     *
     * @var string
     */
    const STATUT_PANIER = 'panier';

    //PRICE
    #[ORM\Column]
    private ?int $prix = null;


    //------- METHODES -------//
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getProduits(): ?string
    {
        return $this->produits;
    }

    public function setProduits(string $produits): static
    {
        $this->produits = $produits;

        return $this;
    }
    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItems $orderItem): self
    {
        foreach ($this->getOrderItems() as $existingItem) {
            // The item already exists, update the quantity
            if ($existingItem->equals($orderItem)) {
                $existingItem->setQuantity(
                    $existingItem->getQuantity() + $orderItem->getQuantity()
                );
                return $this;
            }
        }

        $this->orderItems[] = $orderItem;
        $orderItem->setCommandeRef($this);
        return $this;
    }

    public function removeOrderItem(OrderItems $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {

            if ($orderItem->getCommandeRef() === $this) {
                $orderItem->setCommandeRef(null);
            }
        }
        return $this;
    }


    public function getCommande(): ?\DateTimeInterface
    {
        return $this->commande;
    }

    public function setCommande(\DateTimeInterface $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    public function getEnvoi(): ?\DateTimeInterface
    {
        return $this->envoi;
    }

    public function setEnvoi(?\DateTimeInterface $envoi): static
    {
        $this->envoi = $envoi;

        return $this;
    }

    public function getLivraison(): ?\DateTimeInterface
    {
        return $this->livraison;
    }

    public function setLivraison(?\DateTimeInterface $livraison): static
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Calculates the order total.
     *
     * @return float
     */
    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getOrderItems() as $orderItem) {
            $total += $orderItem->getTotal();
        }

        return $total;
    }


}