<?php

namespace App\Entity;

use App\Repository\EquipesRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: EquipesRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table]
class Equipes implements Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'nom', type: 'string', length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(name: 'nomlong', type: 'string', length: 255, nullable: true)]
    private ?string $nomlong = null;

    #[ORM\Column(name: 'active', type: 'boolean', nullable: true)]
    private bool $active = true;

    #[ORM\Column(name: 'themeRecherche', type: 'text', nullable: true)]
    private ?string $themeRecherche = null;

    #[ORM\ManyToOne(targetEntity: 'MembresCrestic', inversedBy: 'equipes', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'responsable_id', referencedColumnName: 'id')]
    #[ORM\OrderBy(['nom' => 'ASC'])]
    private ?MembresCrestic $responsable = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $created;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updated;

    #[ORM\Column(length: 128, unique: true)]
    private ?string $slug = null;

    #[ORM\OneToMany(targetEntity: 'EquipesHasMembres', mappedBy: 'equipe', cascade: ['persist'])]
    private Collection $membres;

    #[ORM\OneToMany(targetEntity: 'EquipesHasDepartements', mappedBy: 'equipe', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'departement_id', referencedColumnName: 'id')]
    private Collection $departements;

    #[ORM\OneToMany(targetEntity: 'EquipesHasSliders', mappedBy: 'equipe', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'slider_id', referencedColumnName: 'id')]
    private Collection $sliders;

    #[ORM\OneToMany(targetEntity: 'ProjetsHasEquipes', mappedBy: 'equipe', cascade: ['persist'])]
    private Collection $projets;

    #[ORM\Column(name: 'image', type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(name: 'video', type: 'string', length: 255, nullable: true)]
    private ?string $video = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->projets = new ArrayCollection();
        $this->departements = new ArrayCollection();
        $this->sliders = new ArrayCollection();

        $this->created = new DateTime();
        $this->updated = new DateTime();
    }

    public function __toString(): string
    {
        return $this->getNom() ?? '-';
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
     * @return Equipes
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
     * @return Equipes
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get themeRecherche
     *
     * @return string
     */
    public function getThemeRecherche()
    {
        return $this->themeRecherche;
    }

    /**
     * Set themeRecherche
     *
     * @param string $themeRecherche
     *
     * @return Equipes
     */
    public function setThemeRecherche($themeRecherche)
    {
        $this->themeRecherche = $themeRecherche;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return MembresCrestic
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set responsable
     *
     *
     * @return Equipes
     */
    public function setResponsable(MembresCrestic $responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Equipes
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Equipes
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Add membre
     *
     *
     * @return Equipes
     */
    public function addMembre(EquipesHasMembres $membre)
    {
        $this->membres[] = $membre;

        return $this;
    }

    /**
     * Remove membre
     */
    public function removeMembre(EquipesHasMembres $membre)
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
     * Add departement
     *
     *
     * @return Equipes
     */
    public function addDepartement(EquipesHasDepartements $departement)
    {
        $this->departements[] = $departement;

        return $this;
    }

    /**
     * Remove departements
     */
    public function removeDepartement(EquipesHasMembres $departement)
    {
        $this->departements->removeElement($departement);
    }

    /**
     * Get departements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartements()
    {
        return $this->departements;
    }


    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Equipes
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Equipes
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return Equipes
     */
    public function setVideo(?string $video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Equipes
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Add slider
     *
     *
     * @return Equipes
     */
    public function addSlider(EquipesHasSliders $slider)
    {
        $this->sliders[] = $slider;

        return $this;
    }

    /**
     * Remove slider
     */
    public function removeSlider(EquipesHasSliders $slider)
    {
        $this->sliders->removeElement($slider);
    }

    /**
     * Get sliders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSliders()
    {
        return $this->sliders;
    }

    /**
     * Add projet
     *
     *
     * @return Equipes
     */
    public function addProjet(ProjetsHasEquipes $projet)
    {
        $this->projets[] = $projet;

        return $this;
    }

    /**
     * Remove projet
     */
    public function removeProjet(ProjetsHasEquipes $projet)
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

    /**
     * Get nomlong
     *
     * @return string
     */
    public function getNomlong()
    {
        return $this->nomlong;
    }

    /**
     * Set nomlong
     *
     * @param string $nomlong
     *
     * @return Equipes
     */
    public function setNomlong($nomlong)
    {
        $this->nomlong = $nomlong;

        return $this;
    }
}
