<?php

namespace App\Entity;

use App\Repository\PlateformesRepository;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Plateformes
 *
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: PlateformesRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table]
class Plateformes implements Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'nom', type: 'string', length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'localisation', type: 'string', length: 255, nullable: true)]
    private ?string $localisation = null;

    #[ORM\ManyToOne(targetEntity: 'MembresCrestic', inversedBy: 'plateformes')]
    #[ORM\JoinColumn(name: 'responsable_id', referencedColumnName: 'id')]
    #[ORM\OrderBy(['nom' => 'ASC'])]
    private ?MembresCrestic $responsable = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $created = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updated = null;

    #[ORM\Column(length: 128, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(name: 'image', type: 'string', length: 255)]
    private string $image = 'noimage.png';

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="plateformes_images", fileNameProperty="image")
     */
    private ?File $imageFile = null;

    #[ORM\Column(name: 'url', type: 'string', length: 255, nullable: true)]
    private string $url = '';

    #[ORM\OneToMany(mappedBy: 'plateforme', targetEntity: 'ProjetsHasPlateformes', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'projet_id', referencedColumnName: 'id')]
    private Collection $projets;

    #[ORM\OneToMany(mappedBy: 'plateforme', targetEntity: 'PlateformesHasSliders', cascade: ['persist'])]
    private Collection $sliders;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projets = new ArrayCollection();
        $this->sliders = new ArrayCollection();
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
     * @return Plateformes
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
     * @return Plateformes
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get localisation
     *
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set localisation
     *
     * @param string $localisation
     *
     * @return Plateformes
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

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
     * @return Plateformes
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
     * @return Plateformes
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
     * @return Plateformes
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

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
     * @return Plateformes
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

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
     * @return Plateformes
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * @return Plateformes
     */
    public function setImage($image)
    {
        $this->image = $image;

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
     * @return Plateformes
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Add projet
     *
     *
     * @return Plateformes
     */
    public function addProjet(ProjetsHasPlateformes $projet)
    {
        $this->projets[] = $projet;

        return $this;
    }

    /**
     * Remove projet
     */
    public function removeProjet(ProjetsHasPlateformes $projet)
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
     * Add slider
     *
     *
     * @return Plateformes
     */
    public function addSlider(Slider $slider)
    {
        $this->sliders[] = $slider;

        return $this;
    }

    /**
     * Remove slider
     */
    public function removeSlider(Slider $slider)
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
}
