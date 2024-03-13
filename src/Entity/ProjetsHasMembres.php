<?php

namespace App\Entity;

use App\Repository\ProjetsHasMembresRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

/**
 * ProjetsHasMembres
 */
#[ORM\Entity(repositoryClass: ProjetsHasMembresRepository::class)]
#[ORM\Table]
class ProjetsHasMembres implements Stringable
{
    /**
     * @var integer
     */
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'MembresCrestic', inversedBy: 'projets')]
    #[ORM\JoinColumn(name: 'membreCrestic_id', referencedColumnName: 'id')]
    private ?MembresCrestic $membreCrestic = null;

    #[ORM\ManyToOne(targetEntity: 'Projets', inversedBy: 'membres')]
    #[ORM\JoinColumn(name: 'projet_id', referencedColumnName: 'id')]
    private ?Projets $projet = null;

    public function __toString(): string
    {
        return $this->getProjet().' '.$this->getMembreCrestic();
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
     * Set membreCrestic
     *
     *
     * @return ProjetsHasMembres
     */
    public function setMembreCrestic(MembresCrestic $membreCrestic = null)
    {
        $this->membreCrestic = $membreCrestic;

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
     * Set projet
     *
     *
     * @return ProjetsHasMembres
     */
    public function setProjet(Projets $projet = null)
    {
        $this->projet = $projet;

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
}
