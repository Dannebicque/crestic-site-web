<?php

namespace App\Entity;

use App\Repository\DocumentsInternesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentsInternesRepository::class)]
class DocumentsInternes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fichier = null;

    #[ORM\Column(nullable: true)]
    private ?float $size = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\ManyToOne(inversedBy: 'documentsInternes')]
    private ?CategorieDocument $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(?float $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getCategorie(): ?CategorieDocument
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieDocument $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
