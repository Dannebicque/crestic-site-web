<?php

namespace App\Entity;

use App\Repository\ActualitesRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ActualitesRepository::class)]
#[ORM\Table(name: 'actualites')]
class Actualites
{

    #[ORM\Column(type: 'datetime')]
    protected DateTime $created;

    #[ORM\Column(type: 'datetime')]
    protected DateTime $updated;

    #[ORM\ManyToOne(targetEntity: MembresCrestic::class, fetch: 'EAGER', inversedBy: 'actualites')]
    protected ?MembresCrestic $membreCrestic = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected ?string $image = null;

    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'titre', type: 'string', length: 255)]
    private string $titre;

    #[ORM\Column(type: 'date')]
    protected DateTime $dateactu;

    #[ORM\Column(name: 'interne', type: 'boolean')]
    private bool $interne = false;

    #[ORM\Column(name: 'message', type: 'text')]
    private string $message;

    #[ORM\Column(name: 'slug', type: 'string', length: 100)]
    private $slug;

    public function __construct()
    {
        $this->created = new DateTime('now');
        $this->updated = new DateTime('now');
        $this->dateactu = new DateTime('now');
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

    #[ORM\PreUpdate]
    public function preUpdate()
    {
        $this->updated = new DateTime();
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
     * @return Actualites
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Actualites
     */
    public function setMessage($message)
    {
        $this->message = $message;

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
     * @return Actualites
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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
     * @return Actualites
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
     * @return Actualites
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get membreCrestic
     *
     * @return \App\Entity\MembresCrestic
     */
    public function getMembreCrestic()
    {
        return $this->membreCrestic;
    }

    /**
     * Set membreCrestic
     *
     *
     * @return Actualites
     */
    public function setMembreCrestic(MembresCrestic $membreCrestic = null)
    {
        $this->membreCrestic = $membreCrestic;

        return $this;
    }

    /**
     * Set interne
     *
     * @param boolean $interne
     *
     * @return Actualites
     */
    public function setInterne($interne)
    {
        $this->interne = $interne;

        return $this;
    }

    /**
     * Get interne
     *
     * @return boolean
     */
    public function getInterne()
    {
        return $this->interne;
    }

    /**
     * Set dateactu
     *
     * @param \DateTime $dateactu
     *
     * @return Actualites
     */
    public function setDateactu($dateactu)
    {
        $this->dateactu = $dateactu;

        return $this;
    }

    /**
     * Get dateactu
     *
     * @return \DateTime
     */
    public function getDateactu()
    {
        return $this->dateactu;
    }

    public function isPdf()
    {
        //vérifier si l'extension de image est pdf

        return str_ends_with($this->image, '.pdf');
    }
}
