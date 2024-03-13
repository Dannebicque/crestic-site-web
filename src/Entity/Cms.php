<?php

namespace App\Entity;

use App\Repository\CmsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cms
 */
#[ORM\Entity(repositoryClass: CmsRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table]
class Cms implements \Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'titre', type: 'string', length: 255, nullable: true)]
    private ?String $titre = null;

    #[ORM\Column(name: 'texte', type: 'text', nullable: true)]
    private ?string $texte = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $created;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updated;

    #[ORM\Column(length: 250, unique: true)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->created = new DateTime('now');
        $this->updated = new DateTime('now');
    }

    public function __toString(): string
    {
        return $this->getTitre();
    }

    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Cms
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
     * Set id
     *
     * @param $id
     *
     * @return Cms
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return Cms
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

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
     * @return Cms
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
     * @return Cms
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
     * @return Cms
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
