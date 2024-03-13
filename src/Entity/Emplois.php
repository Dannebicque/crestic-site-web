<?php

namespace App\Entity;

use App\Repository\EmploisRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Emplois
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: EmploisRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table]
class Emplois implements Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'titre', type: 'string', length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(name: 'resume', type: 'string', length: 255, nullable: true)]
    private ?string $resume = null;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'debut', type: 'date', nullable: true)]
    private ?DateTime $debut;


    #[ORM\Column(name: 'duree', type: 'string', length: 100, nullable: true)]
    private ?string $duree = null;

    #[ORM\Column(name: 'pourvue', type: 'boolean', nullable: true)]
    private bool $pourvue = false;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $created;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updated;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="emplois_pdf", fileNameProperty="pdf")
     *
     * @var File
     */
    private $pdfFile = '';


    #[ORM\Column(name: 'pdf', type: 'string', length: 255, nullable: true)]
    private ?string $pdf = null;


    #[ORM\ManyToOne(targetEntity: 'MembresCrestic', fetch: 'EAGER', inversedBy: 'emplois')]
    private ?MembresCrestic $contact = null;

    #[ORM\ManyToOne(targetEntity: 'Projets', fetch: 'EAGER', inversedBy: 'emplois')]
    private ?Projets $projet = null;

    public function __construct()
    {
        $this->debut = new DateTime();
        $this->created = new DateTime();
        $this->updated = new DateTime();
    }

    public function __toString(): string
    {
        return $this->getTitre();
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
     * @return Emplois
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

    #[ORM\PreUpdate]
    public function preUpdate()
    {
        $this->updated = new DateTime();
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set resume
     *
     * @param string $resume
     *
     * @return Emplois
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

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
     * @return Emplois
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set debut
     *
     * @param \DateTime $debut
     *
     * @return Emplois
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get duree
     *
     * @return string
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set duree
     *
     * @param string $duree
     *
     * @return Emplois
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

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
     * @return Emplois
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
     * @return Emplois
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return File
     */
    public function getPdfFile()
    {
        return $this->pdfFile;
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
    public function setPdfFile(File|UploadedFile $image = null)
    {
        $this->pdfFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated = new DateTime('now');
        }
    }

    /**
     * Get pdf
     *
     * @return string
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * Set pdf
     *
     * @param string $pdf
     *
     * @return Emplois
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;

        return $this;
    }

    /**
     * Get projet
     *
     * @return Projets
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * Set contact
     *
     *
     * @return Emplois
     */
    public function setProjet(Projets $projet = null)
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * Get contact
     *
     * @return MembresCrestic
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set contact
     *
     *
     * @return Emplois
     */
    public function setContact(MembresCrestic $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get pourvue
     *
     * @return boolean
     */
    public function getPourvue()
    {
        return $this->pourvue;
    }

    /**
     * Set pourvue
     *
     * @param boolean $pourvue
     *
     * @return Emplois
     */
    public function setPourvue($pourvue)
    {
        $this->pourvue = $pourvue;

        return $this;
    }
}
