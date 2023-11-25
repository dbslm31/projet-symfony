<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Subcategory::class)]
    private Collection $subcategories;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Catalogue::class)]
    private Collection $catalogue;

    public function __construct()
    {
        $this->subcategories = new ArrayCollection();
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
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Subcategory>
     */
    public function getSubcategories(): Collection
    {
        return $this->subcategories;
    }

    public function addSubcategory(Subcategory $subcategory): static
    {
        if (!$this->subcategories->contains($subcategory)) {
            $this->subcategories->add($subcategory);
            $subcategory->setCategory($this);
        }

        return $this;
    }

    public function removeSubcategory(Subcategory $subcategory): static
    {
        if ($this->subcategories->removeElement($subcategory)) {
            // set the owning side to null (unless already changed)
            if ($subcategory->getCategory() === $this) {
                $subcategory->setCategory(null);
            }
        }

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
            $catalogue->setCategory($this);
        }

        return $this;
    }

    public function removeCatalogue(Catalogue $catalogue): static
    {
        if ($this->catalogue->removeElement($catalogue)) {
            // set the owning side to null (unless already changed)
            if ($catalogue->getCategory() === $this) {
                $catalogue->setCategory(null);
            }
        }

        return $this;
    }
}
