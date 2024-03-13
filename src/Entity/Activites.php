<?php

namespace App\Entity;

use App\Repository\ActivitesRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Activites
 */
#[ORM\Entity(repositoryClass: ActivitesRepository::class)]
#[ORM\Table(name: 'activites')]
class Activites
{
    #[ORM\Column(type: 'datetime')]
    protected DateTime $created;

    #[ORM\Column(type: 'datetime')]
    protected DateTime $updated;

    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'titre', type: 'string', length: 150)]
    private string $titre;

    #[ORM\Column(name: 'texte', type: 'text')]
    private string $texte;

    public function __construct(#[ORM\ManyToOne(targetEntity: MembresCrestic::class, fetch: 'EAGER', inversedBy: 'activites')]
    protected MembresCrestic $membreCrestic)
    {
        $this->created = new DateTime();
        $this->updated = new DateTime();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updated = new DateTime();
    }

    /**
     * Get id
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }


    public function setTitre(?String $titre): Activites
    {
        $this->titre = $titre;

        return $this;
    }


    public function getTexte(): ?string
    {
        return $this->texte;
    }

    /**
     * Set texte
     *
     * @param string $texte
     *
     * @return Activites
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
     * @return Activites
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
     * @return Activites
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
     * @return Activites
     */
    public function setMembreCrestic(MembresCrestic $membreCrestic = null)
    {
        $this->membreCrestic = $membreCrestic;

        return $this;
    }
}
