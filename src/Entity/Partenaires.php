<?php

namespace App\Entity;

use App\Repository\PartenairesRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Partenaires
 *
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: PartenairesRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table]
class Partenaires implements Stringable
{
    /**
     * @var integer
     */
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;


    #[ORM\Column(name: 'nom', type: 'string', length: 255, nullable: true)]
    private ?string $nom = null;


    #[ORM\Column(name: 'url', type: 'string', length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(name: 'internationale', type: 'boolean', nullable: true)]
    private bool $internationale = false;

    #[ORM\Column(name: 'typePartenaire', type: 'string', length: 1)]
    private ?string $typePartenaire = 'A';


    #[ORM\Column(name: 'image', type: 'string', length: 255)]
    private ?string $image = null;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="partenaires_images", fileNameProperty="image")
     */
    private ?File $imageFile = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $created = null;


    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updated = null;

    #[ORM\OneToMany(mappedBy: 'partenaire', targetEntity: 'ProjetsHasPartenaires', cascade: ['persist'])]
    private Collection $projets;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
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
     * @return Partenaires
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
     * @return Partenaires
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
     * @return Partenaires
     */
    public function setUrl($url)
    {
        $this->url = $url;

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
     * @return Partenaires
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
     * @return Partenaires
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get internationale
     *
     * @return boolean
     */
    public function getInternationale()
    {
        return $this->internationale;
    }

    /**
     * Set internationale
     *
     * @param boolean $internationale
     *
     * @return Partenaires
     */
    public function setInternationale($internationale)
    {
        $this->internationale = $internationale;

        return $this;
    }

    /**
     * Add projet
     *
     *
     * @return Partenaires
     */
    public function addProjet(ProjetsHasPartenaires $projet)
    {
        $this->projets[] = $projet;

        return $this;
    }

    /**
     * Remove projet
     */
    public function removeProjet(ProjetsHasPartenaires $projet)
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
     * Get typePartenaire
     *
     * @return string
     */
    public function getTypePartenaire()
    {
        return $this->typePartenaire;
    }

    /**
     * Set typePartenaire
     *
     * @param string $typePartenaire
     *
     * @return Partenaires
     */
    public function setTypePartenaire($typePartenaire)
    {
        $this->typePartenaire = $typePartenaire;

        return $this;
    }

    /**
     * Get typePartenaireLong
     *
     * @return string
     */
    public function getTypePartenaireLong()
    {
        if ($this->typePartenaire === 'A') {
            return 'Académique';
        }

        return 'Industriel';
    }
}
