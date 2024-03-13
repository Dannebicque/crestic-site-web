<?php

namespace App\Entity;

use App\Repository\ProjetsHasEquipesRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

/**
 * ProjetsHasEquipes
 */
#[ORM\Entity(repositoryClass: ProjetsHasEquipesRepository::class)]
#[ORM\Table]
class ProjetsHasEquipes implements Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'Projets', inversedBy: 'equipes')]
    #[ORM\JoinColumn(name: 'projet_id', referencedColumnName: 'id')]
    private ?Projets $projet = null;

    #[ORM\ManyToOne(targetEntity: 'Equipes', inversedBy: 'projets')]
    #[ORM\JoinColumn(name: 'equipe_id', referencedColumnName: 'id')]
    private ?Equipes $equipe = null;

    public function __toString(): string
    {
        return $this->getProjet().' '.$this->getEquipe();
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
     * @return ProjetsHasEquipes
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
     * Set equipe
     *
     *
     * @return ProjetsHasEquipes
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
}
