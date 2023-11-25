<?php

namespace App\Entity;

use App\Repository\SubcategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubcategoryRepository::class)]
class Subcategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'subcategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'subcategory', targetEntity: Catalogue::class)]
    private Collection $catalogue;

    public function __construct()
    {
        $this->catalogue = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->name = $nom;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Catalogue>
     */
    public function getCatalogue(): Collection
    {
        return $this->catalogue;
    }

    public function addCatalogue(Catalogue $catalogue): static
    {
        if (!$this->catalogue->contains($catalogue)) {
            $this->catalogue->add($catalogue);
            $catalogue->setSubcategory($this);
        }

        return $this;
    }

    public function removeCatalogue(Catalogue $catalogue): static
    {
        if ($this->catalogue->removeElement($catalogue)) {
            // set the owning side to null (unless already changed)
            if ($catalogue->getSubcategory() === $this) {
                $catalogue->setSubcategory(null);
            }
        }

        return $this;
    }
}
