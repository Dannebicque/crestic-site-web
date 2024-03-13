<?php

namespace App\Entity;

use App\Repository\EquipesHasSlidersRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

/**
 * EquipesHasSliders
 */
#[ORM\Entity(repositoryClass: EquipesHasSlidersRepository::class)]
#[ORM\Table]
class EquipesHasSliders implements Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'Equipes', inversedBy: 'sliders')]
    #[ORM\JoinColumn(name: 'equipe_id', referencedColumnName: 'id')]
    private ?Equipes $equipe = null;

    #[ORM\ManyToOne(targetEntity: 'Slider', inversedBy: 'equipes', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'slider_id', referencedColumnName: 'id')]
    private ?Slider $slider = null;

    public function __toString(): string
    {
        return $this->getEquipe().' '.$this->getSlider();
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
     * Set equipe
     *
     *
     * @return EquipesHasSliders
     */
    public function setEquipe(Equipes $equipe = null)
    {
        $this->equipe = $equipe;

        return $this;
    }

    /**
     * Get equipe
     *
     * @return Equipes
     */
    public function getEquipe()
    {
        return $this->equipe;
    }

    /**
     * Set slider
     *
     *
     * @return EquipesHasSliders
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
