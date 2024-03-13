<?php

namespace App\Entity;

use App\Repository\ProjetsHasPartenairesRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

/**
 * ProjetsHasPartenaires
 */
#[ORM\Entity(repositoryClass: ProjetsHasPartenairesRepository::class)]
#[ORM\Table]
class ProjetsHasPartenaires implements Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'Projets', inversedBy: 'partenaires')]
    #[ORM\JoinColumn(name: 'projets_id', referencedColumnName: 'id')]
    private ?Projets $projet = null;

    #[ORM\ManyToOne(targetEntity: 'Partenaires', inversedBy: 'projets')]
    private ?Partenaires $partenaire = null;

    public function __toString(): string
    {
        return $this->getProjet().' '.$this->getPartenaire();
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
     * @return ProjetsHasPartenaires
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
     * Set partenaire
     *
     *
     * @return ProjetsHasPartenaires
     */
    public function setPartenaire(Partenaires $partenaire = null)
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    /**
     * Get partenaire
     *
     * @return Partenaires
     */
    public function getPartenaire()
    {
        return $this->partenaire;
    }

    /**
     * Get financeur
     *
     * @return boolean
     */
    public function getFinanceur()
    {
        return $this->financeur;
    }

    /**
     * Set financeur
     *
     * @param boolean $financeur
     *
     * @return ProjetsHasPartenaires
     */
    public function setFinanceur($financeur)
    {
        $this->financeur = $financeur;

        return $this;
    }
}
