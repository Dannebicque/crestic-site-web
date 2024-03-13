<?php

namespace App\Entity;

use App\Repository\CategorieProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

/**
 * CategorieProjet
 */
#[ORM\Entity(repositoryClass: CategorieProjetRepository::class)]
#[ORM\Table(name: 'categorie_projet')]
class CategorieProjet implements Stringable
{
    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    /**
     * @var string
     */
    #[ORM\Column(name: 'libelle', type: 'string', length: 100)]
    private ?string $libelle = null;

    /**
     * @var string
     */
    #[ORM\Column(name: 'libelle_en', type: 'string', length: 100)]
    private ?string $libelle_en = null;


    #[ORM\OneToMany(targetEntity: Projets::class, mappedBy: 'categorie')]
    #[ORM\OrderBy(['titre' => 'ASC'])]
    private Collection $projets;

    #[ORM\OneToMany(targetEntity: CategorieProjet::class, mappedBy: 'parent')]
    #[ORM\OrderBy(['ordre' => 'ASC'])]
    private Collection $enfants;

    #[ORM\ManyToOne(targetEntity: CategorieProjet::class, inversedBy: 'enfants')]
    private ?CategorieProjet $parent = null;

    #[ORM\Column(type: 'integer')]
    private ?int $ordre = null;

    public function __toString(): string
    {
        return $this->getLibelle();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return CategorieProjet
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set parent
     *
     *
     * @return CategorieProjet
     */
    public function setParent(CategorieProjet $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \App\Entity\CategorieProjet
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set libelleEn
     *
     * @param string $libelleEn
     *
     * @return CategorieProjet
     */
    public function setLibelleEn($libelleEn)
    {
        $this->libelle_en = $libelleEn;

        return $this;
    }

    /**
     * Get libelleEn
     *
     * @return string
     */
    public function getLibelleEn()
    {
        return $this->libelle_en;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enfants = new ArrayCollection();
    }

    /**
     * Add enfant
     *
     *
     * @return CategorieProjet
     */
    public function addEnfant(CategorieProjet $enfant)
    {
        $this->enfants[] = $enfant;

        return $this;
    }

    /**
     * Remove enfant
     */
    public function removeEnfant(CategorieProjet $enfant)
    {
        $this->enfants->removeElement($enfant);
    }

    /**
     * Get enfants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnfants()
    {
        return $this->enfants;
    }

    /**
     * Add projet
     *
     *
     * @return CategorieProjet
     */
    public function addProjet(Projets $projet)
    {
        $this->projets[] = $projet;

        return $this;
    }

    /**
     * Remove projet
     */
    public function removeProjet(Projets $projet)
    {
        $this->projets->removeElement($projet);
    }

    /**
     * Get projets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjets()
    {
        return $this->projets;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }
}
