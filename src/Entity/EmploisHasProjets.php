<?php

namespace App\Entity;

use App\Repository\EmploisHasProjetsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * EmploisHasProjets
 */
#[ORM\Entity(repositoryClass: EmploisHasProjetsRepository::class)]
#[ORM\Table]
class EmploisHasProjets
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'Emplois')]
    private ?Emplois $emploi = null;

    #[ORM\ManyToOne(targetEntity: 'Projets')]
    private ?Projets $projet = null;

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
     * Set emploi
     *
     *
     * @return EmploisHasProjets
     */
    public function setEmploi(Emplois $emploi = null)
    {
        $this->emploi = $emploi;

        return $this;
    }

    /**
     * Get emploi
     *
     * @return Entity\Emplois
     */
    public function getEmploi()
    {
        return $this->emploi;
    }

    /**
     * Set projet
     *
     *
     * @return EmploisHasProjets
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
