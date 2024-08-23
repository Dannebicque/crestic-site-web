<?php

namespace App\Entity;

use App\Repository\MailingListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MailingListRepository::class)]
class MailingList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomlist = null;

    /**
     * @var Collection<int, MembresCrestic>
     */
    #[ORM\ManyToMany(targetEntity: MembresCrestic::class, inversedBy: 'maillingLists')]
    private Collection $MembreCrestic_id;

    /**
     * Constructeur de la classe MailingList.
     */
    public function __construct()
    {
        $this->MembreCrestic_id = new ArrayCollection();
    }

    /**
     * Obtient l'identifiant de la liste de diffusion.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtient le nom de la liste de diffusion.
     *
     * @return string|null
     */
    public function getNomlist(): ?string
    {
        return $this->nomlist;
    }

    /**
     * Définit le nom de la liste de diffusion.
     *
     * @param string|null $nomlist
     *
     * @return $this
     */
    public function setNomlist(?string $nomlist): static
    {
        $this->nomlist = $nomlist;

        return $this;
    }

    /**
     * Retourne la collection de membres associés à cette liste de diffusion.
     *
     * @return Collection<int, MembresCrestic>
     */
    public function getMembreCresticId(): Collection
    {
        return $this->MembreCrestic_id;
    }

    /**
     * Ajoute un membre à la liste de diffusion.
     *
     * @param MembresCrestic $membreCresticId
     *
     * @return $this
     */
    public function addMembreCresticId(MembresCrestic $membreCresticId): static
    {
        if (!$this->MembreCrestic_id->contains($membreCresticId)) {
            $this->MembreCrestic_id->add($membreCresticId);
        }

        return $this;
    }

    /**
     * Supprime un membre de la liste de diffusion.
     *
     * @param MembresCrestic $membreCresticId
     *
     * @return $this
     */
    public function removeMembreCresticId(MembresCrestic $membreCresticId): static
    {
        $this->MembreCrestic_id->removeElement($membreCresticId);

        return $this;
    }
}
