<?php

namespace App\Entity;

use App\Repository\SliderRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Slider
 *
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: SliderRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table]
class Slider implements Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'image', type: 'string', length: 100)]
    private string $image = 'noimage.png';

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="slider_images", fileNameProperty="image")
     */
    private ?File $imageFile = null;

    #[ORM\Column(name: 'url', type: 'string', length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(name: 'titre', type: 'string', length: 100)]
    private ?string $titre = null;

    #[ORM\Column(name: 'texte', type: 'string', length: 255, nullable: true)]
    private ?string $texte = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $created = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updated = null;

    #[ORM\OneToMany(targetEntity: 'EquipesHasSliders', mappedBy: 'slider', cascade: ['persist'])]
    private Collection $equipes;

    #[ORM\OneToMany(targetEntity: 'ProjetsHasSliders', mappedBy: 'slider', cascade: ['persist'])]
    private Collection $projets;

    #[ORM\OneToMany(targetEntity: 'PlateformesHasSliders', mappedBy: 'slider', cascade: ['persist'])]
    private Collection $plateformes;

    #[ORM\ManyToOne(targetEntity: 'MembresCrestic')]
    #[ORM\OrderBy(['nom' => 'ASC'])]
    private ?MembresCrestic $auteur = null;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
        $this->projets = new ArrayCollection();
        $this->plateformes = new ArrayCollection();
        $this->created = new DateTime('now');
        $this->updated = new DateTime('now');
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

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Slider
     */
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
     * @return Slider
     */
    public function setImage($image)
    {
        $this->image = $image;

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
     * @return Slider
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set texte
     *
     * @param string $texte
     *
     * @return Slider
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File|UploadedFile $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new DateTime('now'));
        }
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
     * @return Slider
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
     * @return Slider
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Add equipe
     *
     *
     * @return Slider
     */
    public function addEquipe(EquipesHasSliders $equipe)
    {
        $this->equipes[] = $equipe;

        return $this;
    }

    /**
     * Remove projet
     */
    public function removeEquipe(EquipesHasSliders $equipe)
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
     * Add projet
     *
     *
     * @return Slider
     */
    public function addProjet(ProjetsHasSliders $projet)
    {
        $this->projets[] = $projet;

        return $this;
    }

    /**
     * Remove projet
     */
    public function removeProjet(ProjetsHasSliders $projet)
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
     * Add plateforme
     *
     *
     * @return Slider
     */
    public function addPlateforme(PlateformesHasSliders $plateforme)
    {
        $this->plateformes[] = $plateforme;

        return $this;
    }

    /**
     * Remove projet
     */
    public function removePlateforme(PlateformesHasSliders $plateforme)
    {
        $this->plateformes->removeElement($plateforme);
    }

    /**
     * Get projets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlateformes()
    {
        return $this->plateformes;
    }

    /**
     * Get auteur
     *
     * @return \App\Entity\MembresCrestic
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set auteur
     *
     *
     * @return Slider
     */
    public function setAuteur(MembresCrestic $auteur = null)
    {
        $this->auteur = $auteur;

        return $this;
    }
}
