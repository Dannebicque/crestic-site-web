<?php

namespace App\Entity;

use App\Repository\PlateformesHasSlidersRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

/**
 * PlateformesHasSliders
 */
#[ORM\Entity(repositoryClass: PlateformesHasSlidersRepository::class)]
#[ORM\Table]
class PlateformesHasSliders implements Stringable
{
    /**
     * @var integer
     */
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'Plateformes', inversedBy: 'sliders')]
    private ?Plateformes $plateforme = null;

    #[ORM\ManyToOne(targetEntity: 'Slider', inversedBy: 'plateformes')]
    private ?Slider $slider = null;

    public function __toString(): string
    {
        return $this->getPlateforme().' '.$this->getSlider();
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
     * Set plateforme
     *
     *
     * @return PlateformesHasSliders
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

    /**
     * Set slider
     *
     *
     * @return PlateformesHasSliders
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
