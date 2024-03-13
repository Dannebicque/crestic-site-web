<?php

namespace App\Entity;

use App\Repository\ConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Configuration
 */
#[ORM\Entity(repositoryClass: ConfigurationRepository::class)]
#[ORM\Table]
class Configuration implements \Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'cle', type: 'string', length: 100, nullable: true)]
    private ?string $cle = null;

    #[ORM\Column(name: 'value', type: 'text', nullable: true)]
    private ?string $value = null;

    public function __toString(): string
    {
        return "" . $this->getCle();
    }

    /**
     * Get cle
     *
     * @return string
     */
    public function getCle()
    {
        return $this->cle;
    }

    /**
     * Set cle
     *
     * @param string $cle
     *
     * @return Configuration
     */
    public function setCle($cle)
    {
        $this->cle = $cle;

        return $this;
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
     * Set id
     *
     * @param $id
     *
     * @return Configuration
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Configuration
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    //todo: écrire une méthode générique pour récupérer la valeur par rapport à une clé ? Devrait peut être, être dans un service ? Comment passer le résultat de la requete dans un service ?
}
