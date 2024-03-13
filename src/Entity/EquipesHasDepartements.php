<?php

namespace App\Entity;

use App\Repository\EquipesHasDepartementsRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity(repositoryClass: EquipesHasDepartementsRepository::class)]
#[ORM\Table]
class EquipesHasDepartements implements Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;


    #[ORM\ManyToOne(targetEntity: 'Equipes', fetch: 'EAGER', inversedBy: 'departements')]
    #[ORM\JoinColumn(name: 'equipe_id', referencedColumnName: 'id')]
    private ?Equipes $equipe = null;

    #[ORM\ManyToOne(targetEntity: 'Departements', inversedBy: 'equipes')]
    #[ORM\JoinColumn(name: 'departement_id', referencedColumnName: 'id')]
    private ?Departements $departement = null;

    public function __toString(): string
    {
        return $this->getEquipe().' '.$this->getDepartement();
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
     * @return EquipesHasDepartements
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
     * Set departement
     *
     *
     * @return EquipesHasDepartements
     */
    public function setDepartement(Departements $departement = null)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return Departements
     */
    public function getDepartement()
    {
        return $this->departement;
    }
}
