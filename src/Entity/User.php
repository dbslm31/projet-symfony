<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['mail'], message: 'There is already an account with this mail')]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;
    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class, orphanRemoval: true)]
    private Collection $commandes;

    #[ORM\OneToOne(mappedBy: 'client', cascade: ['persist', 'remove'])]
    private ?Panier $panier = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isVerified = false;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->commandes = new ArrayCollection();
        // Définir le rôle par défaut sur "Client" si le rôle est nul
        $this->role = $roleRepository->findOneBy(['nom' => 'Client']);
    }

// Autres méthodes et propriétés...

// Laissez seulement une déclaration du constructeur
// Vous n'avez plus besoin de la deuxième déclaration


    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;
        return $this;
    }
    public function getUsername(): string
    {
        return $this->mail;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(?string $mdp): self
    {
        $this->mdp = $mdp;
        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): self
    {
        // set the owning side of the relation if necessary
        if ($panier && $panier->getClient() !== $this) {
            $panier->setClient($this);
        }

        $this->panier = $panier;
        return $this;
    }

    // Implementation of UserInterface methods

    public function getRoles(): array
    {
        return [$this->getRole()->getNom()];
    }

    public function getPassword(): string
    {
        return $this->mdp;
    }

    public function getSalt(): ?string
    {
        return null;
    }


    public function eraseCredentials()
    {
        // Remove sensitive data from the user
    }

    public function getUserIdentifier(): string
    {
        return $this->mail;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    public static function createGuest(RoleRepository $roleRepository): self
    {
        $guest = new self($roleRepository); // Utilisez le RoleRepository ici
        $guest->setNom('Invité');
        $guest->setMail('guest@example.com'); // Définissez une adresse email fictive ou laissez-la vide
        $guest->setMdp(''); // Pas de mot de passe pour le client invité
        $guest->setIsVerified(true); // Marquez comme vérifié si nécessaire

        // Configurez d'autres propriétés si nécessaire...

        return $guest;
    }
}
