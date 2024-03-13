<?php

namespace App\Entity;

use App\Repository\MembresHasDepartementsRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

/**
 * MembresHasDepartements
 */
#[ORM\Entity(repositoryClass: MembresHasDepartementsRepository::class)]
#[ORM\Table]
class MembresHasDepartements implements Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;


    #[ORM\ManyToOne(targetEntity: MembresCrestic::class, fetch: 'EAGER')]
    private ?MembresCrestic $membre = null;

    #[ORM\ManyToOne(targetEntity: 'Departements', inversedBy: 'equipes')]
    #[ORM\JoinColumn(name: 'departement_id', referencedColumnName: 'id')]
    private ?Departements $departement = null;

    public function __toString(): string
    {
        return $this->getMembre().' '.$this->getDepartement();
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
     * @return mixed
     */
    public function getMembre()
    {
        return $this->membre;
    }

    public function setMembre(mixed $membre)
    {
        $this->membre = $membre;
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
