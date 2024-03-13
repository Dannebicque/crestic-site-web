<?php

namespace App\Entity;

use App\Repository\DocumentsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Documents
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: DocumentsRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table]
class Documents implements \Stringable
{

    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'titre', type: 'string', length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $created;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updated;

    private $pdfFile = '';

    #[ORM\Column(name: 'pdf', type: 'string', length: 255, nullable: true)]
    private ?string $pdf = null;

    #[ORM\Column(name: 'size', type: 'float', nullable: true)]
    private int $size = 0;

    public function __construct()
    {
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
     * @return Documents
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
     * @return Documents
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * @return Documents
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
     * @return Documents
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
    public function setPdfFile(\Symfony\Component\HttpFoundation\File\File|\Symfony\Component\HttpFoundation\File\UploadedFile $image = null)
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
     * @return Documents
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;

        return $this;
    }

    public function getSize(): float
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize($size): void
    {
        $this->size = $size;
    }


}
