<?php

namespace App\Entity;

use App\Repository\ProjetsHasSlidersRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

/**
 * ProjetsHasSliders
 */
#[ORM\Entity(repositoryClass: ProjetsHasSlidersRepository::class)]
#[ORM\Table]
class ProjetsHasSliders implements Stringable
{
    /**
     * @var integer
     */
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'Projets', inversedBy: 'sliders')]
    #[ORM\JoinColumn(name: 'projets_id', referencedColumnName: 'id')]
    private ?Projets $projet = null;

    #[ORM\ManyToOne(targetEntity: 'Slider', inversedBy: 'projets', cascade: ['persist'])]
    private ?Slider $slider = null;


    public function __toString(): string
    {
        return $this->getProjet().' '.$this->getSlider();
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
     * @return ProjetsHasSliders
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
     * Set slider
     *
     *
     * @return ProjetsHasSliders
     */
    public function setSlider(Slider $slider = null)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider
     *
     * @return Slider
     */
    public function getSlider()
    {
        return $this->slider;
    }
}
