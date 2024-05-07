<?php

namespace App\Entity;

use App\Repository\MaillingListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaillingListRepository::class)]
class MaillingList
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

    public function __construct()
    {
        $this->MembreCrestic_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomlist(): ?string
    {
        return $this->nomlist;
    }

    public function setNomlist(?string $nomlist): static
    {
        $this->nomlist = $nomlist;

        return $this;
    }

    /**
     * @return Collection<int, MembresCrestic>
     */
    public function getMembreCresticId(): Collection
    {
        return $this->MembreCrestic_id;
    }

    public function addMembreCresticId(MembresCrestic $membreCresticId): static
    {
        if (!$this->MembreCrestic_id->contains($membreCresticId)) {
            $this->MembreCrestic_id->add($membreCresticId);
        }

        return $this;
    }

    public function removeMembreCresticId(MembresCrestic $membreCresticId): static
    {
        $this->MembreCrestic_id->removeElement($membreCresticId);

        return $this;
    }
}
