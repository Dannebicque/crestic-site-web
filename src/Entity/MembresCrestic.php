<?php

namespace App\Entity;

use App\Repository\MembresCresticRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;
use const JSON_THROW_ON_ERROR;

/**
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: MembresCresticRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table]
class MembresCrestic implements UserInterface, Stringable
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\Column(name: 'disciplineHCERES', type: 'string', length: 255, nullable: true)]
    private ?string $disciplinehceres = null;

    #[ORM\Column(name: 'username', type: 'string', length: 255)]
    private ?string $username = null;

    #[ORM\Column(name: 'email', type: 'string', length: 255)]
    private ?string $email = null;

    #[ORM\Column(name: 'hdr', type: 'boolean')]
    private bool $hdr = false;

    #[ORM\Column(name: 'datenomination', type: 'datetime', nullable: true)]
    private ?DateTime $datenomination = null;

    #[ORM\Column(name: 'corpsgrade', type: 'string', length: 50, nullable: true)]
    private ?string $corpsgrade = null;

    #[ORM\Column(name: 'idhal', type: 'string', length: 255, nullable: true)]
    private ?string $idhal = null;

    #[ORM\Column(name: 'nom', type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\Column(name: 'prenom', type: 'string', length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(name: 'roles', type: 'string', length: 255, nullable: true)]
    private string $roles;

    #[ORM\Column(name: 'cnu', type: 'string', length: 5, nullable: true)]
    private ?string $cnu = null;

    #[ORM\Column(name: 'status', type: 'string', length: 7, nullable: true)]
    private ?string $status = null; //PR, MCF, IE, ADM, PUPH, MCU-PH...

    #[ORM\Column(name: 'site', type: 'string', length: 100, nullable: true)]
    private ?string $site = null;

    #[ORM\Column(name: 'batiment', type: 'string', length: 50, nullable: true)]
    private ?string $batiment = null;

    #[ORM\Column(name: 'etage', type: 'string', length: 50, nullable: true)]
    private ?string $etage = null;

    #[ORM\Column(name: 'bureau', type: 'string', length: 20, nullable: true)]
    private ?string $bureau = null;

    #[ORM\Column(name: 'emailPerso', type: 'string', length: 255, nullable: true)]
    private ?string $emailPerso = null;

    #[ORM\Column(name: 'adresse', type: 'string', length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\ManyToOne(targetEntity: 'Departements', inversedBy: 'membres')]
    private ?Departements $departementMembre = null;

    #[ORM\OneToMany(targetEntity: 'Actualites', mappedBy: 'membreCrestic')]
    private Collection $actualites;

    #[ORM\OneToMany(targetEntity: Activites::class, mappedBy: 'membreCrestic')]
    private Collection $activites;

    #[ORM\OneToMany(targetEntity: 'Emplois', mappedBy: 'contact')]
    private Collection $emplois;

    #[ORM\OneToMany(targetEntity: 'ProjetsHasMembres', mappedBy: 'membreCrestic')]
    private Collection $projets;

    #[ORM\OneToMany(targetEntity: 'Plateformes', mappedBy: 'responsable')]
    private Collection $plateformes;

    #[ORM\OneToMany(targetEntity: 'EquipesHasMembres', mappedBy: 'membreCrestic')]
    private Collection $equipesHasMembres;

    #[ORM\OneToMany(targetEntity: 'Equipes', mappedBy: 'responsable')]
    private Collection $equipes;

    #[ORM\OneToMany(mappedBy: 'membreCrestic', targetEntity: 'Departements')]
    private Collection $departements;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $created;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updated;

    /**
     * @Gedmo\Slug(fields={"prenom", "nom"})
     */
    #[ORM\Column(length: 128, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(name: 'image', type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="membresCrestic_images", fileNameProperty="image")
     */
    private ?File $imageFile = null;

    #[ORM\Column(name: 'dateNaissance', type: 'date', nullable: true)]
    private ?DateTime $dateNaissance = null;

    #[ORM\Column(name: 'adressePerso', type: 'string', length: 255, nullable: true)]
    private ?string $adressePerso = null;

    #[ORM\Column(name: 'tel', type: 'string', length: 255, nullable: true)]
    private ?string $tel = null;

    #[ORM\Column(name: 'telPortable', type: 'string', length: 255, nullable: true)]
    private ?string $telPortable = null;

    #[ORM\Column(name: 'url', type: 'string', length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(name: 'cv', type: 'text', nullable: true)]
    private ?string $cv = null;

    #[ORM\Column(name: 'cv_en', type: 'text', nullable: true)]
    private ?string $cv_en = null;

    #[ORM\Column(name: 'themes', type: 'text', nullable: true)]
    private ?string $themes = null;

    #[ORM\Column(name: 'themes_en', type: 'text', nullable: true)]
    private ?string $themes_en = null;

    #[ORM\Column(name: 'responsabilitesScientifiques', type: 'text', nullable: true)]
    private ?string $responsabilitesScientifiques = null;

    #[ORM\Column(name: 'responsabilitesScientifiques_en', type: 'text', nullable: true)]
    private ?string $responsabilitesScientifiques_en = null;

    #[ORM\Column(name: 'responsabilitesAdministratives', type: 'text', nullable: true)]
    private ?string $responsabilitesAdministratives = null;

    #[ORM\Column(name: 'responsabilitesAdministratives_en', type: 'text', nullable: true)]
    private ?string $responsabilitesAdministratives_en = null;

    #[ORM\Column(name: 'evaluation', type: 'text', nullable: true)]
    private ?string $evaluation = null;

    #[ORM\Column(name: 'evaluation_en', type: 'text', nullable: true)]
    private ?string $evaluation_en = null;

    #[ORM\Column(name: 'editorial', type: 'text', nullable: true)]
    private ?string $editorial = null;

    #[ORM\Column(name: 'editorial_en', type: 'text', nullable: true)]
    private ?string $editorial_en = null;

    #[ORM\Column(name: 'valorisation', type: 'text', nullable: true)]
    private ?string $valorisation = null;

    #[ORM\Column(name: 'valorisation_en', type: 'text', nullable: true)]
    private ?string $valorisation_en = null;

    #[ORM\Column(name: 'vulgarisation', type: 'text', nullable: true)]
    private ?string $vulgarisation = null;

    #[ORM\Column(name: 'vulgarisation_en', type: 'text', nullable: true)]
    private ?string $vulgarisation_en = null;

    #[ORM\Column(name: 'international', type: 'text', nullable: true)]
    private  $international;

    #[ORM\Column(name: 'international_en', type: 'text', nullable: true)]
    private ?string $international_en = null;

    #[ORM\Column(name: 'membreAssocie', type: 'boolean', nullable: true)]
    private bool $membreAssocie = false;

    #[ORM\Column(name: 'membreConseilLabo', type: 'boolean', nullable: true)]
    private bool $membreConseilLabo = false;

    #[ORM\Column(name: 'enseignements', type: 'text', nullable: true)]
    private ?string $enseignements = null;

    #[ORM\Column(name: 'enseignements_en', type: 'text', nullable: true)]
    private ?string $enseignements_en = null;

    #[ORM\Column(name: 'responsabiliteFonction', type: 'text', nullable: true)]
    private ?string $responsabiliteFonction = null;

    #[ORM\Column(name: 'responsabiliteFonction_en', type: 'text', nullable: true)]
    private ?string $responsabiliteFonction_en = null;

    #[ORM\Column(name: 'ancienMembresCrestic', type: 'boolean')]
    private bool $ancienMembresCrestic = false;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDepart = null;

    /**
     * Membres constructor.
     */
    public function __construct()
    {
        $this->actualites = new ArrayCollection();
        $this->emplois = new ArrayCollection();
        $this->plateformes = new ArrayCollection();
        $this->equipesHasMembres = new ArrayCollection();
        $this->equipes = new ArrayCollection();
        $this->departements = new ArrayCollection();
        $this->activites = new ArrayCollection();
        $this->projets = new ArrayCollection();
        $this->setRoles(["ROLE_UTILISATEUR"]);
        $this->setCreated(new DateTime());
        $this->setUpdated(new DateTime());
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
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image
     *
     *
     * @return MembresCrestic
     */
    public function setImage(?string $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return MembresCrestic
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get adressePerso
     *
     * @return string
     */
    public function getAdressePerso()
    {
        return $this->adressePerso;
    }

    /**
     * Set adressePerso
     *
     * @param string $adressePerso
     *
     * @return MembresCrestic
     */
    public function setAdressePerso($adressePerso)
    {
        $this->adressePerso = $adressePerso;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return MembresCrestic
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get telPortable
     *
     * @return string
     */
    public function getTelPortable()
    {
        return $this->telPortable;
    }

    /**
     * Set telPortable
     *
     * @param string $telPortable
     *
     * @return MembresCrestic
     */
    public function setTelPortable($telPortable)
    {
        $this->telPortable = $telPortable;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return MembresCrestic
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get cv
     *
     * @return string
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * Set cv
     *
     * @param string $cv
     *
     * @return MembresCrestic
     */
    public function setCv($cv)
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * Get themes
     *
     * @return string
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Set themes
     *
     * @param string $themes
     *
     * @return MembresCrestic
     */
    public function setThemes($themes)
    {
        $this->themes = $themes;

        return $this;
    }

    /**
     * Get responsabilitesScientifiques
     *
     * @return string
     */
    public function getResponsabilitesScientifiques()
    {
        return $this->responsabilitesScientifiques;
    }

    /**
     * Set responsabilitesScientifiques
     *
     * @param string $responsabilitesScientifiques
     *
     * @return MembresCrestic
     */
    public function setResponsabilitesScientifiques($responsabilitesScientifiques)
    {
        $this->responsabilitesScientifiques = $responsabilitesScientifiques;

        return $this;
    }

    /**
     * Get responsabilitesAdministratives
     *
     * @return string
     */
    public function getResponsabilitesAdministratives()
    {
        return $this->responsabilitesAdministratives;
    }

    /**
     * Set responsabilitesAdministratives
     *
     * @param string $responsabilitesAdministratives
     *
     * @return MembresCrestic
     */
    public function setResponsabilitesAdministratives($responsabilitesAdministratives)
    {
        $this->responsabilitesAdministratives = $responsabilitesAdministratives;

        return $this;
    }

    /**
     * Get valorisation
     *
     * @return string
     */
    public function getValorisation()
    {
        return $this->valorisation;
    }

    /**
     * Set valorisation
     *
     * @param string $valorisation
     *
     * @return MembresCrestic
     */
    public function setValorisation($valorisation)
    {
        $this->valorisation = $valorisation;

        return $this;
    }

    /**
     * Get vulgarisation
     *
     * @return string
     */
    public function getVulgarisation()
    {
        return $this->vulgarisation;
    }

    /**
     * Set vulgarisation
     *
     * @param string $vulgarisation
     *
     * @return MembresCrestic
     */
    public function setVulgarisation($vulgarisation)
    {
        $this->vulgarisation = $vulgarisation;

        return $this;
    }

    /**
     * Get international
     *
     * @return string
     */
    public function getInternational()
    {
        return $this->international;
    }

    /**
     * Set international
     *
     * @param string $international
     *
     * @return MembresCrestic
     */
    public function setInternational($international)
    {
        $this->international = $international;

        return $this;
    }

    /**
     * Get enseignements
     *
     * @return string
     */
    public function getEnseignements()
    {
        return $this->enseignements;
    }

    /**
     * Set enseignements
     *
     * @param string $enseignements
     *
     * @return MembresCrestic
     */
    public function setEnseignements($enseignements)
    {
        $this->enseignements = $enseignements;

        return $this;
    }

    /**
     * Get ancienMembresCrestic
     *
     * @return boolean
     */
    public function getAncienMembresCrestic()
    {
        return $this->ancienMembresCrestic;
    }

    /**
     * Set ancienMembresCrestic
     *
     * @param boolean $ancienMembresCrestic
     *
     * @return MembresCrestic
     */
    public function setAncienMembresCrestic($ancienMembresCrestic)
    {
        $this->ancienMembresCrestic = $ancienMembresCrestic;

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(
        File|UploadedFile $image = null
    ) {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new DateTime('now'));
        }
    }

    public function __toString(): string
    {
        return $this->getDisplay();
    }

    public function getDisplay()
    {
        return ucfirst($this->prenom) . " " . ucwords(mb_strtolower($this->nom));
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return ucwords($this->prenom);
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return MembresCrestic
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get emailPerso
     *
     * @return string
     */
    public function getEmailPerso()
    {
        return $this->emailPerso;
    }

    /**
     * Set emailPerso
     *
     * @param string $emailPerso
     *
     * @return MembresCrestic
     */
    public function setEmailPerso($emailPerso)
    {
        $this->emailPerso = $emailPerso;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return MembresCrestic
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Add actualite
     *
     *
     * @return MembresCrestic
     */
    public function addActualite(Actualites $actualite)
    {
        $this->actualites[] = $actualite;

        return $this;
    }

    /**
     * Remove actualite
     */
    public function removeActualite(Actualites $actualite)
    {
        $this->actualites->removeElement($actualite);
    }

    /**
     * Get actualites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActualites()
    {
        return $this->actualites;
    }

    /**
     * Add emploi
     *
     *
     * @return MembresCrestic
     */
    public function addEmploi(Emplois $emploi)
    {
        $this->emplois[] = $emploi;

        return $this;
    }

    /**
     * Remove emploi
     */
    public function removeEmploi(Emplois $emploi)
    {
        $this->emplois->removeElement($emploi);
    }

    /**
     * Get emploi
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmplois()
    {
        return $this->emplois;
    }

    /**
     * Add plateforme
     *
     *
     * @return MembresCrestic
     */
    public function addPlateforme(Plateformes $plateforme)
    {
        $this->plateformes[] = $plateforme;

        return $this;
    }

    /**
     * Remove plateforme
     */
    public function removePlateforme(Plateformes $plateforme)
    {
        $this->plateformes->removeElement($plateforme);
    }

    /**
     * Get plateformes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlateformes()
    {
        return $this->plateformes;
    }

    /**
     * Add equipesHasMembre
     *
     *
     * @return MembresCrestic
     */
    public function addEquipesHasMembre(EquipesHasMembres $equipesHasMembre)
    {
        $this->equipesHasMembres[] = $equipesHasMembre;

        return $this;
    }

    /**
     * Remove equipesHasMembre
     */
    public function removeEquipesHasMembre(EquipesHasMembres $equipesHasMembre)
    {
        $this->equipesHasMembres->removeElement($equipesHasMembre);
    }

    /**
     * Get equipesHasMembres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipesHasMembres()
    {
        return $this->equipesHasMembres;
    }

    /**
     * Add equipe
     *
     *
     * @return MembresCrestic
     */
    public function addEquipe(Equipes $equipe)
    {
        $this->equipes[] = $equipe;

        return $this;
    }

    /**
     * Remove equipe
     */
    public function removeEquipe(Equipes $equipe)
    {
        $this->equipes->removeElement($equipe);
    }

    /**
     * Get equipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipes()
    {
        return $this->equipes;
    }

    /**
     * Add departement
     *
     *
     * @return MembresCrestic
     */
    public function addDepartement(Departements $departement)
    {
        $this->departements[] = $departement;

        return $this;
    }

    /**
     * Remove departement
     */
    public function removeDepartement(Departements $departement)
    {
        $this->departements->removeElement($departement);
    }

    /**
     * Get departements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartements()
    {
        return $this->departements;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @return MembresCrestic
     */
    public function setSlug()
    {
        $this->slug = $this->generate_slug($this->prenom . '-' . $this->nom);

        return $this;
    }

    /**
     * @param $str
     *
     * @return string
     */
    public function generate_slug($str)
    {

        $table = [
            'Š' => 'S',
            'š' => 's',
            'Đ' => 'Dj',
            'đ' => 'dj',
            'Ž' => 'Z',
            'ž' => 'z',
            'Č' => 'C',
            'č' => 'c',
            'Ć' => 'C',
            'ć' => 'c',
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'A',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'Þ' => 'B',
            'ß' => 'Ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ý' => 'y',
            'ý' => 'y',
            'þ' => 'b',
            'ÿ' => 'y',
            'Ŕ' => 'R',
            'ŕ' => 'r',
            '/' => '-',
            ' ' => '-'
        ];

        // -- Remove duplicated spaces
        $stripped = preg_replace(['/\s{2,}/', '/[\t\n]/'], ' ', (string)$str);

        // -- Returns the slug
        return strtolower(strtr($str, $table));

    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return MembresCrestic
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get etage
     *
     * @return string
     */
    public function getEtage()
    {
        return $this->etage;
    }

    /**
     * Set etage
     *
     * @param string $etage
     *
     * @return MembresCrestic
     */
    public function setEtage($etage)
    {
        $this->etage = $etage;

        return $this;
    }

    /**
     * Get responsabiliteFonction
     *
     * @return string
     */
    public function getResponsabiliteFonction()
    {
        return $this->responsabiliteFonction;
    }

    /**
     * Set responsabiliteFonction
     *
     * @param string $responsabiliteFonction
     *
     * @return MembresCrestic
     */
    public function setResponsabiliteFonction($responsabiliteFonction)
    {
        $this->responsabiliteFonction = $responsabiliteFonction;

        return $this;
    }

    public function getAuteurIEEE()
    {
//        if ( ($this->getMembreCrestic() === null && $this->getMembreExterieur() === null) || ($this->getMembreCrestic() !== null && $this->getMembreExterieur() !== null))
//        {
//            return 'Err!';
//        } elseif ($this->membreCrestic !== null && $this->membreExterieur === null)
//        {
        //membre crestic
        return $this->getInitialePrenom() . ' ' . $this->getNom();
//        } else
//        {
//            return $this->getMembreExterieur()->getInitialePrenom().' '.$this->getMembreExterieur()->getNom();
//        }
    }

    public function getInitialePrenom()
    {
        $prenom = str_replace(' ', '-', $this->prenom);

        $tprenom = explode('-', $prenom);
        $texte = '';
        foreach ($tprenom as $item) {
            $texte .= strtoupper(substr($item, 0, 1)) . '. ';
        }

        return $texte;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return ucwords($this->nom);
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return MembresCrestic
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get membreAssocie
     *
     * @return boolean
     */
    public function getMembreAssocie()
    {
        return $this->membreAssocie;
    }

    /**
     * Set membreAssocie
     *
     * @param boolean $membreAssocie
     *
     * @return MembresCrestic
     */
    public function setMembreAssocie($membreAssocie)
    {
        $this->membreAssocie = $membreAssocie;

        return $this;
    }

    /**
     * Get membreConseilLabo
     *
     * @return boolean
     */
    public function getMembreConseilLabo()
    {
        return $this->membreConseilLabo;
    }

    /**
     * Set membreConseilLabo
     *
     * @param boolean $membreConseilLabo
     *
     * @return MembresCrestic
     */
    public function setMembreConseilLabo($membreConseilLabo)
    {
        $this->membreConseilLabo = $membreConseilLabo;

        return $this;
    }

    public function getLocalisation()
    {
        $loc = [];
        if ($this->getSite() != '') {
            $loc[] = $this->getSite();
        }

        if ($this->getBatiment() != '') {
            $loc[] = 'bât. ' . $this->getBatiment();
        }

//        if ($this->getEtage() != '')
//        {
//            $loc[] = ', étg. '.$this->getEtage();
//        }

        if ($this->getBureau() != '') {
            $loc[] = 'bur. ' . $this->getBureau();
        }

        if (count($loc) > 0) {
            return implode(', ', $loc);
        } else {
            return '';
        }
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set site
     *
     * @param string $site
     *
     * @return MembresCrestic
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get batiment
     *
     * @return string
     */
    public function getBatiment()
    {
        return $this->batiment;
    }

    /**
     * Set batiment
     *
     * @param string $batiment
     *
     * @return MembresCrestic
     */
    public function setBatiment($batiment)
    {
        $this->batiment = $batiment;

        return $this;
    }

    /**
     * Get bureau
     *
     * @return string
     */
    public function getBureau()
    {
        return $this->bureau;
    }

    /**
     * Set bureau
     *
     * @param string $bureau
     *
     * @return MembresCrestic
     */
    public function setBureau($bureau)
    {
        $this->bureau = $bureau;

        return $this;
    }

    /**
     * Get cnu
     *
     * @return string
     */
    public function getCnu()
    {
        return $this->cnu;
    }

    /**
     * Set cnu
     *
     * @param string $cnu
     *
     * @return MembresCrestic
     */
    public function setCnu($cnu)
    {
        $this->cnu = $cnu;

        return $this;
    }

    /**
     * Add emplois
     *
     *
     * @return MembresCrestic
     */
    public function addEmplois(Emplois $emplois)
    {
        $this->emplois[] = $emplois;

        return $this;
    }

    /**
     * Remove emplois
     */
    public function removeEmplois(Emplois $emplois)
    {
        $this->emplois->removeElement($emplois);
    }

    /**
     * Add projet
     *
     *
     * @return MembresCrestic
     */
    public function addProjet(ProjetsHasMembres $projet)
    {
        $this->projets[] = $projet;

        return $this;
    }

    /**
     * Remove projet
     */
    public function removeProjet(ProjetsHasMembres $projet)
    {
        $this->projets->removeElement($projet);
    }

    /**
     * Get projets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjets()
    {
        return $this->projets;
    }

    /**
     * Get disciplinehceres
     *
     * @return string
     */
    public function getDisciplinehceres()
    {
        return $this->disciplinehceres;
    }

    /**
     * Set disciplinehceres
     *
     * @param string $disciplinehceres
     *
     * @return MembresCrestic
     */
    public function setDisciplinehceres($disciplinehceres)
    {
        $this->disciplinehceres = $disciplinehceres;

        return $this;
    }

    /**
     * Get datenomination
     *
     * @return DateTime
     */
    public function getDatenomination()
    {
        return $this->datenomination;
    }

    /**
     * Set datenomination
     *
     * @param \DateTime $datenomination
     *
     * @return MembresCrestic
     */
    public function setDatenomination($datenomination)
    {
        $this->datenomination = $datenomination;

        return $this;
    }

    /**
     * Get corpsgrade
     *
     * @return string
     */
    public function getCorpsgrade()
    {
        return $this->corpsgrade;
    }

    /**
     * Set corpsgrade
     *
     * @param string $corpsgrade
     *
     * @return MembresCrestic
     */
    public function setCorpsgrade($corpsgrade)
    {
        $this->corpsgrade = $corpsgrade;

        return $this;
    }

    /**
     * Get departementMembre
     *
     * @return Departements
     */
    public function getDepartementMembre()
    {
        return $this->departementMembre;
    }

    /**
     * Set departementMembre
     *
     *
     * @return MembresCrestic
     */
    public function setDepartementMembre(Departements $departementMembre = null)
    {
        $this->departementMembre = $departementMembre;

        return $this;
    }

    public function getStatutLong()
    {
        if ($this->getStatus() === 'MCF') {
            if ($this->getHdr() == true) {
                return 'MCF-HDR';
            } else {
                return $this->getStatus();
            }
        } else if ($this->getStatus() === 'MCU-PH') {
            if ($this->getHdr() == true) {
                return 'MCU-PH HDR';
            } else {
                return $this->getStatus();
            }
        } else {
            return $this->getStatus();
        }
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return MembresCrestic
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get hdr
     *
     * @return boolean
     */
    public function getHdr()
    {
        return $this->hdr;
    }

    /**
     * Set hdr
     *
     * @param boolean $hdr
     *
     * @return MembresCrestic
     */
    public function setHdr($hdr)
    {
        $this->hdr = $hdr;

        return $this;
    }

    /**
     * Add activite
     *
     *
     * @return MembresCrestic
     */
    public function addActivite(Activites $activite)
    {
        $this->activites[] = $activite;

        return $this;
    }

    /**
     * Remove activite
     */
    public function removeActivite(Activites $activite)
    {
        $this->activites->removeElement($activite);
    }

    /**
     * Get activites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActivites()
    {
        return $this->activites;
    }

    /**
     * Get evaluation
     *
     * @return string
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * Set evaluation
     *
     * @param string $evaluation
     *
     * @return MembresCrestic
     */
    public function setEvaluation($evaluation)
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * Get editorial
     *
     * @return string
     */
    public function getEditorial()
    {
        return $this->editorial;
    }

    /**
     * Set editorial
     *
     * @param string $editorial
     *
     * @return MembresCrestic
     */
    public function setEditorial($editorial)
    {
        $this->editorial = $editorial;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdhal()
    {
        return $this->idhal;
    }

    /**
     * @param string $idhal
     */
    public function setIdhal($idhal)
    {
        $this->idhal = $idhal;
    }

    /**
     * @return string
     */
    public function getCvEn()
    {
        return $this->cv_en;
    }

    /**
     * @param string $cv_en
     */
    public function setCvEn($cv_en)
    {
        $this->cv_en = $cv_en;
    }

    /**
     * @return string
     */
    public function getThemesEn()
    {
        return $this->themes_en;
    }

    /**
     * @param string $themes_en
     */
    public function setThemesEn($themes_en)
    {
        $this->themes_en = $themes_en;
    }

    /**
     * @return string
     */
    public function getResponsabilitesScientifiquesEn()
    {
        return $this->responsabilitesScientifiques_en;
    }

    /**
     * @param string $responsabilitesScientifiques_en
     */
    public function setResponsabilitesScientifiquesEn($responsabilitesScientifiques_en)
    {
        $this->responsabilitesScientifiques_en = $responsabilitesScientifiques_en;
    }

    /**
     * @return string
     */
    public function getResponsabilitesAdministrativesEn()
    {
        return $this->responsabilitesAdministratives_en;
    }

    /**
     * @param string $responsabilitesAdministratives_en
     */
    public function setResponsabilitesAdministrativesEn($responsabilitesAdministratives_en)
    {
        $this->responsabilitesAdministratives_en = $responsabilitesAdministratives_en;
    }

    /**
     * @return string
     */
    public function getEvaluationEn()
    {
        return $this->evaluation_en;
    }

    /**
     * @param string $evaluation_en
     */
    public function setEvaluationEn($evaluation_en)
    {
        $this->evaluation_en = $evaluation_en;
    }

    /**
     * @return string
     */
    public function getEditorialEn()
    {
        return $this->editorial_en;
    }

    /**
     * @param string $editorial_en
     */
    public function setEditorialEn($editorial_en)
    {
        $this->editorial_en = $editorial_en;
    }

    /**
     * @return string
     */
    public function getValorisationEn()
    {
        return $this->valorisation_en;
    }

    /**
     * @param string $valorisation_en
     */
    public function setValorisationEn($valorisation_en)
    {
        $this->valorisation_en = $valorisation_en;
    }

    /**
     * @return string
     */
    public function getVulgarisationEn()
    {
        return $this->vulgarisation_en;
    }

    /**
     * @param string $vulgarisation_en
     */
    public function setVulgarisationEn($vulgarisation_en)
    {
        $this->vulgarisation_en = $vulgarisation_en;
    }

    /**
     * @return string
     */
    public function getInternationalEn()
    {
        return $this->international_en;
    }

    /**
     * @param string $international_en
     */
    public function setInternationalEn($international_en)
    {
        $this->international_en = $international_en;
    }

    /**
     * @return string
     */
    public function getEnseignementsEn()
    {
        return $this->enseignements_en;
    }

    /**
     * @param string $enseignements_en
     */
    public function setEnseignementsEn($enseignements_en)
    {
        $this->enseignements_en = $enseignements_en;
    }

    /**
     * @return string
     */
    public function getResponsabiliteFonctionEn()
    {
        return $this->responsabiliteFonction_en;
    }

    /**
     * @param string $responsabiliteFonction_en
     */
    public function setResponsabiliteFonctionEn($responsabiliteFonction_en)
    {
        $this->responsabiliteFonction_en = $responsabiliteFonction_en;
    }

    /**
     * @throws JsonException
     */
    public function setRoles(array $roles): void
    {
        $this->roles = json_encode($roles, JSON_THROW_ON_ERROR);
    }

    public function getRoles(): array
    {
        $roles = json_decode($this->roles);

        // Afin d'être sûr qu'un user a toujours au moins 1 rôle
        if (empty($roles)) {
            $roles[] = 'ROLE_UTILISATEUR';
        }

        // recopier les valeurs dans les clés du tableau $roles

        return array_unique($roles);
    }


    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function initiales()
    {
        $ini = substr($this->prenom, 0, 1) . substr($this->nom, 0, 1);

        return mb_strtoupper($ini);
    }

    public function serialize()
    {
        return serialize([$this->id, $this->username, $this->image]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        [
            $this->id,
            $this->username,
            $this->image
        ] = unserialize($serialized);
    }



    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(?\DateTimeInterface $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }
}
