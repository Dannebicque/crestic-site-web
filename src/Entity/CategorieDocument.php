<?php

namespace App\Entity;

use App\Repository\CategorieDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieDocumentRepository::class)]
class CategorieDocument implements \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $libelle = null;

    #[ORM\OneToMany(targetEntity: CategorieDocument::class, mappedBy: 'categorieParent')]
    #[ORM\OrderBy(['libelle' => 'ASC'])]
    private Collection $enfants;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $categorieParent = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: DocumentsInternes::class)]
    private Collection $documentsInternes;

    public function __construct()
    {
        $this->documentsInternes = new ArrayCollection();
        $this->enfants = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getLibelle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCategorieParent(): ?self
    {
        return $this->categorieParent;
    }

    public function setCategorieParent(?self $categorieParent): self
    {
        $this->categorieParent = $categorieParent;

        return $this;
    }

    /**
     * @return Collection<int, DocumentsInternes>
     */
    public function getDocumentsInternes(): Collection
    {
        return $this->documentsInternes;
    }

    public function addDocumentsInterne(DocumentsInternes $documentsInterne): self
    {
        if (!$this->documentsInternes->contains($documentsInterne)) {
            $this->documentsInternes->add($documentsInterne);
            $documentsInterne->setCategorie($this);
        }

        return $this;
    }

    public function removeDocumentsInterne(DocumentsInternes $documentsInterne): self
    {
        if ($this->documentsInternes->removeElement($documentsInterne)) {
            // set the owning side to null (unless already changed)
            if ($documentsInterne->getCategorie() === $this) {
                $documentsInterne->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategorieDocument>
     */
    public function getEnfants(): Collection
    {
        return $this->enfants;
    }

    public function addEnfant(CategorieDocument $enfant): self
    {
        if (!$this->enfants->contains($enfant)) {
            $this->enfants->add($enfant);
            $enfant->setCategorieParent($this);
        }

        return $this;
    }

    public function removeEnfant(CategorieDocument $enfant): self
    {
        if ($this->enfants->removeElement($enfant)) {
            // set the owning side to null (unless already changed)
            if ($enfant->getCategorieParent() === $this) {
                $enfant->setCategorieParent(null);
            }
        }

        return $this;
    }
}
