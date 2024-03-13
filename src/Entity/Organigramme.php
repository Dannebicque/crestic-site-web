<?php

namespace App\Entity;

use App\Repository\OrganigrammeRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

/**
 * Organigramme
 */
#[ORM\Entity(repositoryClass: OrganigrammeRepository::class)]
#[ORM\Table]
class Organigramme implements Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'MembresCrestic', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'membreCrestic_id', referencedColumnName: 'id')]
    private ?MembresCrestic $membreCrestic = null;

    #[ORM\Column(name: 'responsabiliteFonction', type: 'text', nullable: true)]
    private ?string $responsabiliteFonction = null;

    #[ORM\Column(name: 'ordre', type: 'integer')]
    private int $ordre = 1;


    public function __toString(): string
    {
        return $this->membreCrestic . ' ' . $this->responsabiliteFonction;
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
     * Get responsabiliteFonction
     *
     * @return boolean
     */
    public function getResponsabiliteFonction()
    {
        return $this->responsabiliteFonction;
    }

    /**
     * Set responsabiliteFonction
     *
     * @param boolean $responsabiliteFonction
     *
     * @return Organigramme
     */
    public function setResponsabiliteFonction($responsabiliteFonction)
    {
        $this->responsabiliteFonction = $responsabiliteFonction;

        return $this;
    }

    /**
     * Get membreCrestic
     *
     * @return MembresCrestic
     */
    public function getMembreCrestic()
    {
        return $this->membreCrestic;
    }

    /**
     * Set membreCrestic
     *
     *
     * @return Organigramme
     */
    public function setMembreCrestic(MembresCrestic $membreCrestic = null)
    {
        $this->membreCrestic = $membreCrestic;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Organigramme
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }
}
