<?php

namespace App\Entity;

use App\Repository\ProjetsRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Projets
 *
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: ProjetsRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table]
class Projets implements Stringable
{

    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'titre', type: 'string', length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    /**
     * @Gedmo\Slug(fields={"titre"})
     */
    #[ORM\Column(length: 128, unique: true, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(name: 'image', type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(name: 'dateDebut', type: 'date')]
    private ?DateTime $dateDebut = null;

    #[ORM\Column(name: 'definestime', type: 'date')]
    private ?DateTime $dateFin = null;

    #[ORM\Column(name: 'porteurprojet', type: 'string', length: 255, nullable: true)]
    private ?string $porteurprojet = null;

    #[ORM\ManyToOne(targetEntity: 'MembresCrestic', cascade: ['persist'], inversedBy: 'equipes')]
    #[ORM\JoinColumn(name: 'responable_id', referencedColumnName: 'id')]
    #[ORM\OrderBy(['nom' => 'ASC'])]
    private ?MembresCrestic $responsable = null;

    #[ORM\Column(name: 'financement', type: 'string', length: 255, nullable: true)]
    private ?string $financement = null;

    #[ORM\Column(name: 'identification', type: 'string', length: 255, nullable: true)]
    private ?string $identification = null;

    #[ORM\Column(name: 'url', type: 'string', length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(name: 'budgetGlobal', nullable: true)]
    private ?float $budgetGlobal = null;

    #[ORM\Column(name: 'actif', type: 'boolean')]
    private bool $actif = true;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $created;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updated;

    #[ORM\Column(name: 'video', type: 'string', length: 255, nullable: true)]
    private ?string $video = null;

    #[ORM\Column(name: 'projetInternational', type: 'boolean')]
    private bool $projetInternational = false;

    #[ORM\Column(name: 'projetValorisation', type: 'boolean')]
    private bool $projetValorisation = false;

    #[ORM\Column(name: 'projetThese', type: 'boolean')]
    private bool $projetThese = false;

    #[ORM\Column(name: 'projetRi', type: 'boolean')]
    private bool $projetRi = false;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private ?string $typeprojet = null;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: 'ProjetsHasEquipes', cascade: ['persist'])]
    private Collection $equipes;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: 'ProjetsHasMembres', cascade: ['persist'])]
    private Collection $membres;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: 'ProjetsHasPartenaires', cascade: ['persist'])]
    private Collection $partenaires;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: ProjetsHasFinanceurs::class, cascade: ['persist'])]
    private Collection $financeurs;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: 'ProjetsHasPlateformes', cascade: ['persist'])]
    private Collection $plateformes;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: 'ProjetsHasSliders', cascade: ['persist'])]
    private Collection $sliders;


    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: 'Emplois', fetch: 'EAGER')]
    private Collection $emplois;

    #[ORM\ManyToOne(targetEntity: 'CategorieProjet', inversedBy: 'projets')]
    private ?CategorieProjet $categorie = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new DateTime('now');
        $this->updated = new DateTime('now');

        $this->equipes = new ArrayCollection();
        $this->membres = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
        $this->plateformes = new ArrayCollection();
        $this->sliders = new ArrayCollection();
        $this->emplois = new ArrayCollection();
    }

    public function __toString(): string
    {
        return '' . $this->getTitre();
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;

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
     * @return Projets
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Projets
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Projets
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Projets
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get financement
     *
     * @return string
     */
    public function getFinancement()
    {
        return $this->financement;
    }

    /**
     * Set financement
     *
     * @param string $financement
     *
     * @return Projets
     */
    public function setFinancement($financement)
    {
        $this->financement = $financement;

        return $this;
    }

    /**
     * Get identification
     *
     * @return string
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * Set identification
     *
     * @param string $identification
     *
     * @return Projets
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;

        return $this;
    }

    public function getBudgetGlobal()
    {
        return $this->budgetGlobal;
    }

    public function setBudgetGlobal($budgetGlobal)
    {
        $this->budgetGlobal = $budgetGlobal;

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
     * @return Projets
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     *
     * @return Projets
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

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
     *
     * @return Projets
     */
    public function setImage(?string $image)
    {
        $this->image = $image;

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
     * @return Projets
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
     * @return Projets
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

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
     * @return Projets
     */
    public function setResponsable(MembresCrestic $responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Projets
     */
    public function setUrl($url)
    {
        $this->url = $url;

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
     * @return Projets
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get projetInternational
     *
     * @return boolean
     */
    public function getProjetInternational()
    {
        return $this->projetInternational;
    }

    /**
     * Set projetInternational
     *
     * @param boolean $projetInternational
     *
     * @return Projets
     */
    public function setProjetInternational($projetInternational)
    {
        $this->projetInternational = $projetInternational;

        return $this;
    }

    /**
     * Get projetValorisation
     *
     * @return boolean
     */
    public function getProjetValorisation()
    {
        return $this->projetValorisation;
    }

    /**
     * Set projetValorisation
     *
     * @param boolean $projetValorisation
     *
     * @return Projets
     */
    public function setProjetValorisation($projetValorisation)
    {
        $this->projetValorisation = $projetValorisation;

        return $this;
    }

    /**
     * Get projetThese
     *
     * @return boolean
     */
    public function getProjetThese()
    {
        return $this->projetThese;
    }

    /**
     * Set projetThese
     *
     * @param boolean $projetThese
     *
     * @return Projets
     */
    public function setProjetThese($projetThese)
    {
        $this->projetThese = $projetThese;

        return $this;
    }

    /**
     * Get projetRi
     *
     * @return boolean
     */
    public function getProjetRi()
    {
        return $this->projetRi;
    }

    /**
     * Set projetRi
     *
     * @param boolean $projetRi
     *
     * @return Projets
     */
    public function setProjetRi($projetRi)
    {
        $this->projetRi = $projetRi;

        return $this;
    }

    /**
     * Add equipe
     *
     *
     * @return Projets
     */
    public function addEquipe(ProjetsHasEquipes $equipe)
    {
        $this->equipes[] = $equipe;

        return $this;
    }

    /**
     * Remove equipe
     */
    public function removeEquipe(ProjetsHasEquipes $equipe)
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
     * @return Projets
     */
    public function addMembre(ProjetsHasMembres $membre)
    {
        $this->membres[] = $membre;

        return $this;
    }

    /**
     * Remove membre
     */
    public function removeMembre(ProjetsHasMembres $membre)
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
     * Add partenaire
     *
     *
     * @return Projets
     */
    public function addPartenaire(ProjetsHasPartenaires $partenaire)
    {
        $this->partenaires[] = $partenaire;

        return $this;
    }

    /**
     * Remove partenaire
     */
    public function removePartenaire(ProjetsHasPartenaires $partenaire)
    {
        $this->partenaires->removeElement($partenaire);
    }

    /**
     * Get partenaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartenaires()
    {
        return $this->partenaires;
    }

    /**
     * Add plateforme
     *
     *
     * @return Projets
     */
    public function addPlateforme(ProjetsHasPlateformes $plateforme)
    {
        $this->plateformes[] = $plateforme;

        return $this;
    }

    /**
     * Remove plateforme
     */
    public function removePlateforme(ProjetsHasPlateformes $plateforme)
    {
        $this->plateformes->removeElement($plateforme);
    }

    /**
     * Get plateformes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlateformes()
    {
        return $this->plateformes;
    }

    /**
     * Add plateformes
     *
     *
     * @return Projets
     */
    public function addPlateformes(ProjetsHasPlateformes $plateformes)
    {
        $this->plateformes[] = $plateformes;

        return $this;
    }

    /**
     * Remove slider
     */
    public function removeSlider(ProjetsHasSliders $slider)
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
     * Add slider
     *
     *
     * @return Projets
     */
    public function addSlider(ProjetsHasSliders $slider)
    {
        $this->sliders[] = $slider;

        return $this;
    }

    /**
     * Add emploi
     *
     *
     * @return Projets
     */
    public function addEmploi(Emplois $emploi)
    {
        $this->emplois[] = $emploi;

        return $this;
    }

    /**
     * Remove emploi
     */
    public function removeEmploi(Emplois $emploi)
    {
        $this->emplois->removeElement($emploi);
    }

    /**
     * Get emploi
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmplois()
    {
        return $this->emplois;
    }

    /**
     * Add emplois
     *
     *
     * @return Projets
     */
    public function addEmplois(Emplois $emplois)
    {
        $this->emplois[] = $emplois;

        return $this;
    }

    /**
     * Remove emplois
     */
    public function removeEmplois(Emplois $emplois)
    {
        $this->emplois->removeElement($emplois);
    }

    /**
     * Add financeur
     *
     *
     * @return Projets
     */
    public function addFinanceur(ProjetsHasFinanceurs $financeur)
    {
        $this->financeurs[] = $financeur;

        return $this;
    }

    /**
     * Remove financeur
     */
    public function removeFinanceur(ProjetsHasFinanceurs $financeur)
    {
        $this->financeurs->removeElement($financeur);
    }

    /**
     * Get financeurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFinanceurs()
    {
        return $this->financeurs;
    }

    /**
     * @return string
     */
    public function getTypeprojet()
    {
        return $this->typeprojet;
    }

    public function setTypeprojet(?string $typeprojet)
    {
        $this->typeprojet = $typeprojet;
    }



    /**
     * Set categorie
     *
     *
     * @return Projets
     */
    public function setCategorie(CategorieProjet $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \App\Entity\CategorieProjet
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set porteurprojet
     *
     * @param string $porteurprojet
     *
     * @return Projets
     */
    public function setPorteurprojet($porteurprojet)
    {
        $this->porteurprojet = $porteurprojet;

        return $this;
    }

    /**
     * Get porteurprojet
     *
     * @return string
     */
    public function getPorteurprojet()
    {
        return $this->porteurprojet;
    }
}
