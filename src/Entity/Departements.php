<?php

namespace App\Entity;

use App\Repository\DepartementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

/**
 * Departements
 */
#[ORM\Entity(repositoryClass: DepartementsRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table]
class Departements implements Stringable
{

    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;


    #[ORM\Column(name: 'nom', type: 'string', length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(name: 'sigle', type: 'string', length: 20, nullable: true)]
    private ?string $sigle = null;

    #[ORM\Column(name: 'theme', type: 'text', nullable: true)]
    private ?string $theme = null;

    #[ORM\ManyToOne(targetEntity: 'MembresCrestic', inversedBy: 'departements')]
    #[ORM\JoinColumn(name: 'membreCrestic_id', referencedColumnName: 'id')]
    private ?MembresCrestic $membreCrestic = null;

    #[ORM\OneToMany(targetEntity: 'EquipesHasDepartements', mappedBy: 'departement')]
    private Collection $equipes;

    #[ORM\Column(name: 'slug', type: 'string', length: 100)]
    private ?string $slug = null;

    #[ORM\OneToMany(targetEntity: 'MembresCrestic', mappedBy: 'departementMembre')]
    private Collection $membres;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipes = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getNom();
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Departements
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param $id
     *
     * @return Departements
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set theme
     *
     * @param string $theme
     *
     * @return Departements
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get membreCrestic
     *
     * @return MembresCrestic
     */
    public function getMembreCrestic()
    {
        return $this->membreCrestic;
    }

    /**
     * Set membreCrestic
     *
     * @param MembresCrestic|null $membreCrestic
     *
     * @return Departements
     */
    public function setMembreCrestic(MembresCrestic $membreCrestic = null)
    {
        $this->membreCrestic = $membreCrestic;

        return $this;
    }

    /**
     * Add equipe
     *
     *
     * @return Departements
     */
    public function addEquipe(EquipesHasDepartements $equipe)
    {
        $this->equipes[] = $equipe;

        return $this;
    }

    /**
     * Remove equipe
     */
    public function removeEquipe(EquipesHasDepartements $equipe)
    {
        $this->equipes->removeElement($equipe);
    }

    /**
     * Get equipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipes()
    {
        return $this->equipes;
    }

    /**
     * Add membre
     *
     *
     * @return Departements
     */
    public function addMembre(MembresCrestic $membre)
    {
        $this->membres[] = $membre;

        return $this;
    }

    /**
     * Remove membre
     */
    public function removeMembre(MembresCrestic $membre)
    {
        $this->membres->removeElement($membre);
    }

    /**
     * Get membres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembres()
    {
        return $this->membres;
    }

    /**
     * Get sigle
     *
     * @return string
     */
    public function getSigle()
    {
        return $this->sigle;
    }

    /**
     * Set sigle
     *
     * @param string $sigle
     *
     * @return Departements
     */
    public function setSigle($sigle)
    {
        $this->sigle = $sigle;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Departements
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
