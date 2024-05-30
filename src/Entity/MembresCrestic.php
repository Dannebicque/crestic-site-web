<?php

namespace App\Entity;

use App\Repository\MembresCresticRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonException;
use Stringable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
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
class MembresCrestic implements UserInterface, Stringable, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\Column(name: 'disciplineHCERES', type: 'string', length: 255, nullable: true)]
    private ?string $disciplinehceres = null;

    #[ORM\Column(name: 'username', type: 'string', length: 255)]
    private ?string $username = null;

    #[ORM\Column(nullable: true)]
    private ?string $password = null;

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

    #[ORM\OneToMany(mappedBy: 'membreCrestic', targetEntity: 'Actualites')]
    private Collection $actualites;

    #[ORM\OneToMany(mappedBy: 'membreCrestic', targetEntity: Activites::class)]
    private Collection $activites;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: 'Emplois')]
    private Collection $emplois;

    #[ORM\OneToMany(mappedBy: 'membreCrestic', targetEntity: 'ProjetsHasMembres')]
    private Collection $projets;

    #[ORM\OneToMany(mappedBy: 'responsable', targetEntity: 'Plateformes')]
    private Collection $plateformes;

    #[ORM\OneToMany(mappedBy: 'membreCrestic', targetEntity: 'EquipesHasMembres')]
    private Collection $equipesHasMembres;

    #[ORM\OneToMany(mappedBy: 'responsable', targetEntity: 'Equipes')]
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
    private string $international;

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
    private ?DateTimeInterface $dateDepart = null;

    /**
     * @var Collection<int, MailingList>
     */
    #[ORM\ManyToMany(targetEntity: MailingList::class, mappedBy: 'MembreCrestic_id')]
    private Collection $mailingLists;

    /**
     * Membres constructor.
     * @throws JsonException
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
        $this->mailingLists = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Set image
     *
     * @param string|null $image
     *
     * @return MembresCrestic
     */
    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return DateTime|null
     */
    public function getDateNaissance(): ?DateTime
    {
        return $this->dateNaissance;
    }

    /**
     * Set dateNaissance
     *
     * @param DateTime $dateNaissance
     *
     * @return MembresCrestic
     */
    public function setDateNaissance(DateTime $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get adressePerso
     *
     * @return string|null
     */
    public function getAdressePerso(): ?string
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
    public function setAdressePerso(string $adressePerso): static
    {
        $this->adressePerso = $adressePerso;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string|null
     */
    public function getTel(): ?string
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
    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get telPortable
     *
     * @return string|null
     */
    public function getTelPortable(): ?string
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
    public function setTelPortable(string $telPortable): static
    {
        $this->telPortable = $telPortable;

        return $this;
    }

    /**
     * Get url
     *
     * @return string|null
     */
    public function getUrl(): ?string
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
    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get cv
     *
     * @return string|null
     */
    public function getCv(): ?string
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
    public function setCv(string $cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * Get themes
     *
     * @return string|null
     */
    public function getThemes(): ?string
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
    public function setThemes(string $themes): static
    {
        $this->themes = $themes;

        return $this;
    }

    /**
     * Get responsabilitesScientifiques
     *
     * @return string|null
     */
    public function getResponsabilitesScientifiques(): ?string
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
    public function setResponsabilitesScientifiques(string $responsabilitesScientifiques): static
    {
        $this->responsabilitesScientifiques = $responsabilitesScientifiques;

        return $this;
    }

    /**
     * Get responsabilitesAdministratives
     *
     * @return string|null
     */
    public function getResponsabilitesAdministratives(): ?string
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
    public function setResponsabilitesAdministratives(string $responsabilitesAdministratives): static
    {
        $this->responsabilitesAdministratives = $responsabilitesAdministratives;

        return $this;
    }

    /**
     * Get valorisation
     *
     * @return string|null
     */
    public function getValorisation(): ?string
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
    public function setValorisation(string $valorisation): static
    {
        $this->valorisation = $valorisation;

        return $this;
    }

    /**
     * Get vulgarisation
     *
     * @return string|null
     */
    public function getVulgarisation(): ?string
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
    public function setVulgarisation(string $vulgarisation): static
    {
        $this->vulgarisation = $vulgarisation;

        return $this;
    }

    /**
     * Get international
     *
     * @return string
     */
    public function getInternational(): string
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
    public function setInternational(string $international): static
    {
        $this->international = $international;

        return $this;
    }

    /**
     * Get enseignements
     *
     * @return string|null
     */
    public function getEnseignements(): ?string
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
    public function setEnseignements(string $enseignements): static
    {
        $this->enseignements = $enseignements;

        return $this;
    }

    /**
     * Get ancienMembresCrestic
     *
     * @return boolean
     */
    public function getAncienMembresCrestic(): bool
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
    public function setAncienMembresCrestic(bool $ancienMembresCrestic): static
    {
        $this->ancienMembresCrestic = $ancienMembresCrestic;

        return $this;
    }

    /**
     * Get imageFile
     *
     * @return File|null
     */
    public function getImageFile(): ?File
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
     * @param File|UploadedFile|null $image
     */
    public function setImageFile(File|UploadedFile $image = null): void
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new DateTime('now'));
        }
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom(): string
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
    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Convertit l'objet en une représentation sous forme de chaîne.
     *
     * @return string La représentation sous forme de chaîne.
     */
    public function __toString(): string
    {
        return $this->getDisplay();
    }

    /**
     * Obtient une représentation à afficher du membre (prénom et nom formatés).
     *
     * @return string La représentation à afficher du membre.
     */
    public function getDisplay(): string
    {
        return ucfirst($this->prenom) . " " . ucwords(mb_strtolower($this->nom));
    }

    /**
     * Obtient les initiales de l'utilisateur (première lettre du prénom et du nom).
     *
     * @return array|false|string|null Les initiales en majuscules, ou null si le prénom ou le nom ne sont pas définis.
     */
    public function initiales(): array|false|string|null
    {
        $ini = substr($this->prenom, 0, 1) . substr($this->nom, 0, 1);

        return mb_strtoupper($ini);
    }

    /**
     * Get emailPerso
     *
     * @return string|null
     */
    public function getEmailPerso(): ?string
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
    public function setEmailPerso(string $emailPerso): static
    {
        $this->emailPerso = $emailPerso;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string|null
     */
    public function getAdresse(): ?string
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
    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Add actualite
     *
     * @param Actualites $actualite
     *
     * @return MembresCrestic
     */
    public function addActualite(Actualites $actualite): static
    {
        $this->actualites[] = $actualite;

        return $this;
    }

    /**
     * Remove actualite
     *
     * @param Actualites $actualite
     */
    public function removeActualite(Actualites $actualite): void
    {
        $this->actualites->removeElement($actualite);
    }

    /**
     * Get actualites
     *
     * @return ArrayCollection|Collection
     */
    public function getActualites(): ArrayCollection|Collection
    {
        return $this->actualites;
    }

    /**
     * Add emploi
     *
     * @param Emplois $emploi
     *
     * @return MembresCrestic
     */
    public function addEmploi(Emplois $emploi): static
    {
        $this->emplois[] = $emploi;

        return $this;
    }

    /**
     * Remove emploi
     *
     * @param Emplois $emploi
     */
    public function removeEmploi(Emplois $emploi): void
    {
        $this->emplois->removeElement($emploi);
    }

    /**
     * Get emploi
     *
     * @return ArrayCollection|Collection
     */
    public function getEmplois(): ArrayCollection|Collection
    {
        return $this->emplois;
    }

    /**
     * Add plateforme
     *
     * @param Plateformes $plateforme
     *
     * @return MembresCrestic
     */
    public function addPlateforme(Plateformes $plateforme): static
    {
        $this->plateformes[] = $plateforme;

        return $this;
    }

    /**
     * Remove plateforme
     *
     * @param Plateformes $plateforme
     */
    public function removePlateforme(Plateformes $plateforme): void
    {
        $this->plateformes->removeElement($plateforme);
    }

    /**
     * Get plateformes
     *
     * @return ArrayCollection|Collection
     */
    public function getPlateformes(): ArrayCollection|Collection
    {
        return $this->plateformes;
    }

    /**
     * Add equipesHasMembre
     *
     * @param EquipesHasMembres $equipesHasMembre
     *
     * @return MembresCrestic
     */
    public function addEquipesHasMembre(EquipesHasMembres $equipesHasMembre): static
    {
        $this->equipesHasMembres[] = $equipesHasMembre;

        return $this;
    }

    /**
     * Remove equipesHasMembre
     *
     * @param EquipesHasMembres $equipesHasMembre
     */
    public function removeEquipesHasMembre(EquipesHasMembres $equipesHasMembre): void
    {
        $this->equipesHasMembres->removeElement($equipesHasMembre);
    }

    /**
     * Get equipesHasMembres
     *
     * @return ArrayCollection|Collection
     */
    public function getEquipesHasMembres(): ArrayCollection|Collection
    {
        return $this->equipesHasMembres;
    }

    /**
     * Add equipe
     *
     * @param Equipes $equipe
     *
     * @return MembresCrestic
     */
    public function addEquipe(Equipes $equipe): static
    {
        $this->equipes[] = $equipe;

        return $this;
    }

    /**
     * Remove equipe
     *
     * @param Equipes $equipe
     */
    public function removeEquipe(Equipes $equipe): void
    {
        $this->equipes->removeElement($equipe);
    }

    /**
     * Get equipes
     *
     * @return ArrayCollection|Collection
     */
    public function getEquipes(): ArrayCollection|Collection
    {
        return $this->equipes;
    }

    /**
     * Add departement
     *
     * @param Departements $departement
     *
     * @return MembresCrestic
     */
    public function addDepartement(Departements $departement): static
    {
        $this->departements[] = $departement;

        return $this;
    }

    /**
     * Remove departement
     *
     * @param Departements $departement
     */
    public function removeDepartement(Departements $departement): void
    {
        $this->departements->removeElement($departement);
    }

    /**
     * Get departements
     *
     * @return ArrayCollection|Collection
     */
    public function getDepartements(): ArrayCollection|Collection
    {
        return $this->departements;
    }

    /**
     * Get slug
     *
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @return MembresCrestic
     */
    public function setSlug(): static
    {
        $this->slug = $this->generate_slug($this->prenom . '-' . $this->nom);

        return $this;
    }

    /**
     * Generate slug
     *
     * @param $str
     *
     * @return string
     */
    public function generate_slug($str): string
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
            'ỳ' => 'y',
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
        return strtolower(strtr($stripped, $table));
    }

    /**
     * Get created
     *
     * @return DateTime|null
     */
    public function getCreated(): ?DateTime
    {
        return $this->created;
    }

    /**
     * Set created
     *
     * @param DateTime $created
     *
     * @return MembresCrestic
     */
    public function setCreated(DateTime $created): static
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get updated
     *
     * @return DateTime|null
     */
    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    /**
     * Set updated
     *
     * @param $updated
     *
     * @return MembresCrestic
     */
    public function setUpdated($updated): static
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get etage
     *
     * @return string|null
     */
    public function getEtage(): ?string
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
    public function setEtage(string $etage): static
    {
        $this->etage = $etage;

        return $this;
    }

    /**
     * Get responsabiliteFonction
     *
     * @return string|null
     */
    public function getResponsabiliteFonction(): ?string
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
    public function setResponsabiliteFonction(string $responsabiliteFonction): static
    {
        $this->responsabiliteFonction = $responsabiliteFonction;

        return $this;
    }

    /**
     * Obtient l'auteur au format IEEE (initiales du prénom suivies du nom).
     *
     * @return string L'auteur au format IEEE.
     */
    public function getAuteurIEEE(): string
    {
        return $this->getInitialePrenom() . ' ' . $this->getNom();
    }

    /**
     * Obtient les initiales du prénom de l'auteur.
     *
     * @return string Les initiales du prénom de l'auteur.
     */
    public function getInitialePrenom(): string
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
    public function getNom(): string
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
    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Obtient le nom d'utilisateur.
     *
     * @return string|null Le nom d'utilisateur ou null si non défini.
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Définit le nom d'utilisateur.
     *
     * @param string $username Le nom d'utilisateur.
     *
     * @return MembresCrestic L'instance actuelle pour permettre l'enchaînement.
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Obtient l'identifiant unique de l'utilisateur.
     *
     * @return string L'identifiant unique de l'utilisateur (nom d'utilisateur).
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    /**
     * Obtient l'adresse email de l'utilisateur.
     *
     * @return string|null L'adresse email de l'utilisateur ou null si non définie.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Définit l'adresse email de l'utilisateur.
     *
     * @param string $email L'adresse email de l'utilisateur.
     *
     * @return MembresCrestic L'instance actuelle pour permettre l'enchaînement.
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Obtient le mot de passe de l'utilisateur.
     *
     * @return string|null Le mot de passe de l'utilisateur ou null si non défini.
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Get membreAssocie
     *
     * @return boolean
     */
    public function getMembreAssocie(): bool
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
    public function setMembreAssocie(bool $membreAssocie): static
    {
        $this->membreAssocie = $membreAssocie;

        return $this;
    }

    /**
     * Get membreConseilLabo
     *
     * @return boolean
     */
    public function getMembreConseilLabo(): bool
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
    public function setMembreConseilLabo(bool $membreConseilLabo): static
    {
        $this->membreConseilLabo = $membreConseilLabo;

        return $this;
    }

    /**
     * Obtient la localisation complète de l'auteur (site, bâtiment, bureau).
     *
     * @return string La localisation complète de l'auteur.
     */
    public function getLocalisation(): string
    {
        $loc = [];
        if ($this->getSite() != '') {
            $loc[] = $this->getSite();
        }

        if ($this->getBatiment() != '') {
            $loc[] = 'bât. ' . $this->getBatiment();
        }

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
     * @return string|null
     */
    public function getSite(): ?string
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
    public function setSite(string $site): static
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get batiment
     *
     * @return string|null
     */
    public function getBatiment(): ?string
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
    public function setBatiment(string $batiment): static
    {
        $this->batiment = $batiment;

        return $this;
    }

    /**
     * Get bureau
     *
     * @return string|null
     */
    public function getBureau(): ?string
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
    public function setBureau(string $bureau): static
    {
        $this->bureau = $bureau;

        return $this;
    }

    /**
     * Get cnu
     *
     * @return string|null
     */
    public function getCnu(): ?string
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
    public function setCnu(string $cnu): static
    {
        $this->cnu = $cnu;

        return $this;
    }

    /**
     * Add emplois
     *
     * @param Emplois $emplois
     *
     * @return MembresCrestic
     */
    public function addEmplois(Emplois $emplois): static
    {
        $this->emplois[] = $emplois;

        return $this;
    }

    /**
     * Remove emplois
     *
     * @param Emplois $emplois
     */
    public function removeEmplois(Emplois $emplois): void
    {
        $this->emplois->removeElement($emplois);
    }

    /**
     * Add projet
     *
     * @param ProjetsHasMembres $projet
     *
     * @return MembresCrestic
     */
    public function addProjet(ProjetsHasMembres $projet): static
    {
        $this->projets[] = $projet;

        return $this;
    }

    /**
     * Remove projet
     *
     * @param ProjetsHasMembres $projet
     */
    public function removeProjet(ProjetsHasMembres $projet): void
    {
        $this->projets->removeElement($projet);
    }

    /**
     * Get projets
     *
     * @return ArrayCollection|Collection
     */
    public function getProjets(): ArrayCollection|Collection
    {
        return $this->projets;
    }

    /**
     * Get disciplinehceres
     *
     * @return string|null
     */
    public function getDisciplinehceres(): ?string
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
    public function setDisciplinehceres(string $disciplinehceres): static
    {
        $this->disciplinehceres = $disciplinehceres;

        return $this;
    }

    /**
     * Get datenomination
     *
     * @return DateTime|null
     */
    public function getDatenomination(): ?DateTime
    {
        return $this->datenomination;
    }

    /**
     * Set datenomination
     *
     * @param DateTime $datenomination
     *
     * @return MembresCrestic
     */
    public function setDatenomination(DateTime $datenomination): static
    {
        $this->datenomination = $datenomination;

        return $this;
    }

    /**
     * Obtient la date de départ de l'utilisateur.
     *
     * @return DateTimeInterface|null La date de départ ou null si non définie.
     */
    public function getDateDepart(): ?DateTimeInterface
    {
        return $this->dateDepart;
    }

    /**
     * Définit la date de départ de l'utilisateur.
     *
     * @param DateTimeInterface|null $dateDepart La date de départ.
     *
     * @return self L'instance actuelle pour permettre l'enchaînement.
     */
    public function setDateDepart(?DateTimeInterface $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    /**
     * Get corpsgrade
     *
     * @return string|null
     */
    public function getCorpsgrade(): ?string
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
    public function setCorpsgrade(string $corpsgrade): static
    {
        $this->corpsgrade = $corpsgrade;

        return $this;
    }

    /**
     * Get departementMembre
     *
     * @return Departements|null
     */
    public function getDepartementMembre(): ?Departements
    {
        return $this->departementMembre;
    }

    /**
     * Set departementMembre
     *
     * @param Departements|null $departementMembre
     *
     * @return MembresCrestic
     */
    public function setDepartementMembre(Departements $departementMembre = null): static
    {
        $this->departementMembre = $departementMembre;

        return $this;
    }

    /**
     * Obtient le statut détaillé de l'auteur.
     *
     * @return string|null Le statut détaillé de l'auteur, incluant HDR si applicable.
     */
    public function getStatutLong(): ?string
    {
        if ($this->getStatus() === 'MCF') {
            if ($this->getHdr()) {
                return 'MCF-HDR';
            } else {
                return $this->getStatus();
            }
        } else if ($this->getStatus() === 'MCU-PH') {
            if ($this->getHdr()) {
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
     * @return string|null
     */
    public function getStatus(): ?string
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
    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get hdr
     *
     * @return boolean
     */
    public function getHdr(): bool
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
    public function setHdr(bool $hdr): static
    {
        $this->hdr = $hdr;

        return $this;
    }

    /**
     * Add activite
     *
     * @param Activites $activite
     *
     * @return MembresCrestic
     */
    public function addActivite(Activites $activite): static
    {
        $this->activites[] = $activite;

        return $this;
    }

    /**
     * Remove activite
     *
     * @param Activites $activite
     */
    public function removeActivite(Activites $activite): void
    {
        $this->activites->removeElement($activite);
    }

    /**
     * Get activites
     *
     * @return ArrayCollection|Collection
     */
    public function getActivites(): ArrayCollection|Collection
    {
        return $this->activites;
    }

    /**
     * Get evaluation
     *
     * @return string|null
     */
    public function getEvaluation(): ?string
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
    public function setEvaluation(string $evaluation): static
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * Get editorial
     *
     * @return string|null
     */
    public function getEditorial(): ?string
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
    public function setEditorial(string $editorial): static
    {
        $this->editorial = $editorial;

        return $this;
    }

    /**
     * Obtient l'identifiant HAL de l'auteur.
     *
     * @return string|null L'identifiant HAL ou null si non défini.
     */
    public function getIdhal(): ?string
    {
        return $this->idhal;
    }

    /**
     * Définit l'identifiant HAL de l'auteur.
     *
     * @param string $idhal L'identifiant HAL.
     */
    public function setIdhal(string $idhal): void
    {
        $this->idhal = $idhal;
    }

    /**
     * Obtient le CV en anglais de l'auteur.
     *
     * @return string|null Le CV en anglais ou null si non défini.
     */
    public function getCvEn(): ?string
    {
        return $this->cv_en;
    }

    /**
     * Définit le CV en anglais de l'auteur.
     *
     * @param string $cv_en Le CV en anglais.
     */
    public function setCvEn(string $cv_en): void
    {
        $this->cv_en = $cv_en;
    }

    /**
     * Obtient les thèmes de recherche en anglais de l'auteur.
     *
     * @return string|null Les thèmes de recherche en anglais ou null si non défini.
     */
    public function getThemesEn(): ?string
    {
        return $this->themes_en;
    }

    /**
     * Définit les thèmes de recherche en anglais de l'auteur.
     *
     * @param string $themes_en Les thèmes de recherche en anglais.
     */
    public function setThemesEn(string $themes_en): void
    {
        $this->themes_en = $themes_en;
    }

    /**
     * Obtient les responsabilités scientifiques en anglais de l'auteur.
     *
     * @return string|null Les responsabilités scientifiques en anglais ou null si non défini.
     */
    public function getResponsabilitesScientifiquesEn(): ?string
    {
        return $this->responsabilitesScientifiques_en;
    }

    /**
     * Définit les responsabilités scientifiques en anglais de l'auteur.
     *
     * @param string $responsabilitesScientifiques_en Les responsabilités scientifiques en anglais.
     */
    public function setResponsabilitesScientifiquesEn(string $responsabilitesScientifiques_en): void
    {
        $this->responsabilitesScientifiques_en = $responsabilitesScientifiques_en;
    }

    /**
     * Obtient les responsabilités administratives en anglais de l'auteur.
     *
     * @return string|null Les responsabilités administratives en anglais ou null si non défini.
     */
    public function getResponsabilitesAdministrativesEn(): ?string
    {
        return $this->responsabilitesAdministratives_en;
    }

    /**
     * Définit les responsabilités administratives en anglais de l'auteur.
     *
     * @param string $responsabilitesAdministratives_en Les responsabilités administratives en anglais.
     */
    public function setResponsabilitesAdministrativesEn(string $responsabilitesAdministratives_en): void
    {
        $this->responsabilitesAdministratives_en = $responsabilitesAdministratives_en;
    }

    /**
     * Obtient l'évaluation en anglais de l'auteur.
     *
     * @return string|null L'évaluation en anglais ou null si non défini.
     */
    public function getEvaluationEn(): ?string
    {
        return $this->evaluation_en;
    }

    /**
     * Définit l'évaluation en anglais de l'auteur.
     *
     * @param string $evaluation_en L'évaluation en anglais.
     */
    public function setEvaluationEn(string $evaluation_en): void
    {
        $this->evaluation_en = $evaluation_en;
    }

    /**
     * Obtient les responsabilités éditoriales en anglais de l'auteur.
     *
     * @return string|null Les responsabilités éditoriales en anglais ou null si non défini.
     */
    public function getEditorialEn(): ?string
    {
        return $this->editorial_en;
    }

    /**
     * Définit les responsabilités éditoriales en anglais de l'auteur.
     *
     * @param string $editorial_en Les responsabilités éditoriales en anglais.
     */
    public function setEditorialEn(string $editorial_en): void
    {
        $this->editorial_en = $editorial_en;
    }

    /**
     * Obtient les activités de valorisation en anglais de l'auteur.
     *
     * @return string|null Les activités de valorisation en anglais ou null si non défini.
     */
    public function getValorisationEn(): ?string
    {
        return $this->valorisation_en;
    }

    /**
     * Définit les activités de valorisation en anglais de l'auteur.
     *
     * @param string $valorisation_en Les activités de valorisation en anglais.
     */
    public function setValorisationEn(string $valorisation_en): void
    {
        $this->valorisation_en = $valorisation_en;
    }

    /**
     * Obtient les activités de vulgarisation en anglais de l'auteur.
     *
     * @return string|null Les activités de vulgarisation en anglais ou null si non défini.
     */
    public function getVulgarisationEn(): ?string
    {
        return $this->vulgarisation_en;
    }

    /**
     * Définit les activités de vulgarisation en anglais de l'auteur.
     *
     * @param string $vulgarisation_en Les activités de vulgarisation en anglais.
     */
    public function setVulgarisationEn(string $vulgarisation_en): void
    {
        $this->vulgarisation_en = $vulgarisation_en;
    }

    /**
     * Obtient les activités internationales en anglais de l'auteur.
     *
     * @return string|null Les activités internationales en anglais ou null si non défini.
     */
    public function getInternationalEn(): ?string
    {
        return $this->international_en;
    }

    /**
     * Définit les activités internationales en anglais de l'auteur.
     *
     * @param string $international_en Les activités internationales en anglais.
     */
    public function setInternationalEn(string $international_en): void
    {
        $this->international_en = $international_en;
    }

    /**
     * Obtient les enseignements en anglais de l'auteur.
     *
     * @return string|null Les enseignements en anglais ou null si non défini.
     */
    public function getEnseignementsEn(): ?string
    {
        return $this->enseignements_en;
    }

    /**
     * Définit les enseignements en anglais de l'auteur.
     *
     * @param string $enseignements_en Les enseignements en anglais.
     */
    public function setEnseignementsEn(string $enseignements_en): void
    {
        $this->enseignements_en = $enseignements_en;
    }

    /**
     * Obtient les responsabilités fonctionnelles en anglais de l'auteur.
     *
     * @return string|null Les responsabilités fonctionnelles en anglais ou null si non défini.
     */
    public function getResponsabiliteFonctionEn(): ?string
    {
        return $this->responsabiliteFonction_en;
    }

    /**
     * Définit les responsabilités fonctionnelles en anglais de l'auteur.
     *
     * @param string $responsabiliteFonction_en Les responsabilités fonctionnelles en anglais.
     */
    public function setResponsabiliteFonctionEn(string $responsabiliteFonction_en): void
    {
        $this->responsabiliteFonction_en = $responsabiliteFonction_en;
    }

    /**
     * Définit les rôles de l'utilisateur.
     *
     * @param array $roles Les rôles de l'utilisateur.
     *
     * @throws JsonException En cas d'erreur lors de l'encodage JSON.
     */
    public function setRoles(array $roles): void
    {
        $this->roles = json_encode($roles, JSON_THROW_ON_ERROR);
    }

    /**
     * Obtient les rôles de l'utilisateur.
     *
     * @return array Les rôles de l'utilisateur.
     */
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

    /**
     * Obtient le sel utilisé pour encoder le mot de passe.
     *
     * @return void
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Efface les informations sensibles de l'utilisateur.
     *
     * @return void
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Sérialise les informations de l'utilisateur.
     *
     * @return string La chaîne sérialisée représentant l'objet utilisateur.
     */
    public function serialize(): string
    {
        return serialize([
            $this->id,
            $this->username,
            $this->image
            ]
        );
    }

    /**
     * Désérialise les informations de l'utilisateur.
     *
     * @param string $serialized La chaîne sérialisée représentant l'objet utilisateur.
     *
     * @return void
     *
     * @see \Serializable::unserialize()
     */
    public function unserialize(string $serialized): void
    {
        [
            $this->id,
            $this->username,
            $this->image
        ] = unserialize($serialized);
    }

    /**
     * Obtient les listes de diffusion auxquelles l'utilisateur appartient.
     *
     * @return Collection<int, MailingList> Une collection de listes de diffusion.
     */
    public function getMailingLists(): Collection
    {
        return $this->mailingLists;
    }

    /**
     * Ajoute une liste de diffusion à l'utilisateur.
     *
     * @param MailingList $mailingList La liste de diffusion à ajouter.
     *
     * @return self L'instance actuelle pour permettre l'enchaînement.
     */
    public function addMailingList(MailingList $mailingList): static
    {
        if (!$this->mailingLists->contains($mailingList)) {
            $this->mailingLists->add($mailingList);
            $mailingList->addMembreCresticId($this);
        }

        return $this;
    }

    /**
     * Retire une liste de diffusion de l'utilisateur.
     *
     * @param MailingList $mailingList La liste de diffusion à retirer.
     *
     * @return self L'instance actuelle pour permettre l'enchaînement.
     */
    public function removeMailingList(MailingList $mailingList): static
    {
        if ($this->mailingLists->removeElement($mailingList)) {
            $mailingList->removeMembreCresticId($this);
        }

        return $this;
    }
}
