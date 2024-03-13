<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cms
 */
#[ORM\Entity(repositoryClass: PaysRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table]
class Pays implements \Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'code', type: 'integer')]
    private ?int $code = null;

    #[ORM\Column(name: 'alpha2', type: 'string', length: 255)]
    private ?string $alpha2 = null;

    #[ORM\Column(name: 'alpha3', type: 'string', length: 255)]
    private ?string $alpha3 = null;

    #[ORM\Column(name: 'nomEN', type: 'string', length: 255)]
    private ?string $nomEN = null;

    #[ORM\Column(name: 'nomFR', type: 'string', length: 255)]
    private ?string $nomFR = null;

    public function __toString(): string
    {
        return $this->getNomFR();
    }

    /**
     * Get nomFR
     *
     * @return string
     */
    public function getNomFR()
    {
        return $this->nomFR;
    }

    /**
     * Set nomFR
     *
     * @param string $nomFR
     *
     * @return Pays
     */
    public function setNomFR($nomFR)
    {
        $this->nomFR = $nomFR;

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
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code
     *
     * @param integer $code
     *
     * @return Pays
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get alpha2
     *
     * @return string
     */
    public function getAlpha2()
    {
        return $this->alpha2;
    }

    /**
     * Set alpha2
     *
     * @param string $alpha2
     *
     * @return Pays
     */
    public function setAlpha2($alpha2)
    {
        $this->alpha2 = $alpha2;

        return $this;
    }

    /**
     * Get alpha3
     *
     * @return string
     */
    public function getAlpha3()
    {
        return $this->alpha3;
    }

    /**
     * Set alpha3
     *
     * @param string $alpha3
     *
     * @return Pays
     */
    public function setAlpha3($alpha3)
    {
        $this->alpha3 = $alpha3;

        return $this;
    }

    /**
     * Get nomEN
     *
     * @return string
     */
    public function getNomEN()
    {
        return $this->nomEN;
    }

    /**
     * Set nomEN
     *
     * @param string $nomEN
     *
     * @return Pays
     */
    public function setNomEN($nomEN)
    {
        $this->nomEN = $nomEN;

        return $this;
    }
}
