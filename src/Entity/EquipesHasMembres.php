<?php

namespace App\Entity;

use App\Repository\EquipesHasMembresRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;


/**
 * EquipesHasMembres
 */
#[ORM\Entity(repositoryClass: EquipesHasMembresRepository::class)]
#[ORM\Table]
class EquipesHasMembres implements Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'Equipes', inversedBy: 'membres')]
    #[ORM\JoinColumn(name: 'equipe_id', referencedColumnName: 'id')]
    private ?Equipes $equipe = null;

    #[ORM\ManyToOne(targetEntity: 'MembresCrestic', inversedBy: 'equipesHasMembres')]
    #[ORM\JoinColumn(name: 'membreCrestic_id', referencedColumnName: 'id')]
    private ?MembresCrestic $membreCrestic = null;

    public function __toString(): string
    {
        return $this->getEquipe().' '.$this->getMembreCrestic();
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
     * @return EquipesHasMembres
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
     * Set membre
     *
     * @param MembresCrestic|null $membreCrestic
     *
     * @return EquipesHasMembres
     */
    public function setMembreCrestic(MembresCrestic $membreCrestic = null)
    {
        $this->membreCrestic = $membreCrestic;

        return $this;
    }

    /**
     * Get membre
     *
     * @return MembresCrestic
     */
    public function getMembreCrestic()
    {
        return $this->membreCrestic;
    }
}
