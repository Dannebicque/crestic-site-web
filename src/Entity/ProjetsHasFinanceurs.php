<?php

namespace App\Entity;

use App\Repository\ProjetsHasFinanceursRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProjetsHasFinanceurs
 */
#[ORM\Entity(repositoryClass: ProjetsHasFinanceursRepository::class)]
#[ORM\Table]
class ProjetsHasFinanceurs
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'Projets', inversedBy: 'financeurs')]
    #[ORM\JoinColumn(name: 'projets_id', referencedColumnName: 'id')]
    private ?Projets $projet = null;

    #[ORM\ManyToOne(targetEntity: Financeurs::class, inversedBy: 'projets')]
    private ?Financeurs $financeur = null;

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
     * @return ProjetsHasFinanceurs
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
     * Set financeur
     *
     *
     * @return ProjetsHasFinanceurs
     */
    public function setFinanceur(Financeurs $financeur = null)
    {
        $this->financeur = $financeur;

        return $this;
    }

    /**
     * Get financeur
     *
     * @return Financeurs
     */
    public function getFinanceur()
    {
        return $this->financeur;
    }
}
