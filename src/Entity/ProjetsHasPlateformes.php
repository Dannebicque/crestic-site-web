<?php

namespace App\Entity;

use App\Repository\ProjetsHasPlateformesRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

/**
 * ProjetsHasPlateformes
 */
#[ORM\Entity(repositoryClass: ProjetsHasPlateformesRepository::class)]
#[ORM\Table]
class ProjetsHasPlateformes implements Stringable
{
    /**
     * @var integer
     */
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'Projets', inversedBy: 'plateformes')]
    #[ORM\JoinColumn(name: 'projets_id', referencedColumnName: 'id')]
    private ?Projets $projet = null;

    #[ORM\ManyToOne(targetEntity: 'Plateformes', inversedBy: 'projets')]
    private ?Plateformes $plateforme = null;


    public function __toString(): string
    {
        return $this->getProjet().' '.$this->getPlateforme();
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
     * Set projet
     *
     *
     * @return ProjetsHasPlateformes
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

    /**
     * Set plateforme
     *
     *
     * @return ProjetsHasPlateformes
     */
    public function setPlateforme(Plateformes $plateforme = null)
    {
        $this->plateforme = $plateforme;

        return $this;
    }

    /**
     * Get plateforme
     *
     * @return Plateformes
     */
    public function getPlateforme()
    {
        return $this->plateforme;
    }
}
