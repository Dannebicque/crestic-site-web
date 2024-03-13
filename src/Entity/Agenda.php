<?php

namespace App\Entity;

use App\Repository\AgendaRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgendaRepository::class)]
#[ORM\Table]
class Agenda implements \Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'titre', type: 'string', length: 255, nullable: true)]
    private ?string $titre = null;


    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'datedebut', type: 'date')]
    private ?DateTime $datedebut;

    #[ORM\Column(name: 'datefin', type: 'date', nullable: true)]
    private ?DateTime $datefin = null;

    #[ORM\Column(name: 'heuredebut', type: 'time')]
    private ?DateTime $heuredebut = null;


    #[ORM\Column(name: 'heurefin', type: 'time', nullable: true)]
    private ?DateTime $heurefin = null;


    #[ORM\Column(name: 'lieu', type: 'string', length: 255, nullable: true)]
    private ?string $lieu = null;

    #[ORM\Column(name: 'type', type: 'string', length: 255, nullable: true)]
    private ?string $type = null; //Séminaires du laboratoire, Conférences, Soutenances Thèses/HDR, Réunions, Autres évenements

    public function __construct()
    {
        $this->datedebut = new DateTime('now');
    }

    public function __toString(): string
    {
        return '' . $this->getTitre();
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Agenda
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

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
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Agenda
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datedebut
     *
     * @param \DateTime $datedebut
     *
     * @return Agenda
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set datefin
     *
     * @param \DateTime $datefin
     *
     * @return Agenda
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Agenda
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Agenda
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get heuredebut
     *
     * @return \DateTime
     */
    public function getHeuredebut()
    {
        return $this->heuredebut;
    }

    /**
     * Set heuredebut
     *
     * @param \DateTime $heuredebut
     *
     * @return Agenda
     */
    public function setHeuredebut($heuredebut)
    {
        $this->heuredebut = $heuredebut;

        return $this;
    }

    /**
     * Get heurefin
     *
     * @return \DateTime
     */
    public function getHeurefin()
    {
        return $this->heurefin;
    }

    /**
     * Set heurefin
     *
     * @param \DateTime $heurefin
     *
     * @return Agenda
     */
    public function setHeurefin($heurefin)
    {
        $this->heurefin = $heurefin;

        return $this;
    }
}
