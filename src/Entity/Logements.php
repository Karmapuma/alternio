<?php

namespace App\Entity;

use App\Repository\LogementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogementsRepository::class)]
class Logements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column]
    private ?int $surface = null;

    #[ORM\Column]
    private ?int $loyer = null;

    #[ORM\Column]
    private ?int $charges = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $nb_place = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_ajout = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'LocationFK')]
    private Collection $locataire;

    #[ORM\ManyToOne(inversedBy: 'ProprietaireFK')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $Owner = null;

    public function __construct()
    {
        $this->locataire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): static
    {
        $this->surface = $surface;

        return $this;
    }

    public function getLoyer(): ?int
    {
        return $this->loyer;
    }

    public function setLoyer(int $loyer): static
    {
        $this->loyer = $loyer;

        return $this;
    }

    public function getCharges(): ?int
    {
        return $this->charges;
    }

    public function setCharges(int $charges): static
    {
        $this->charges = $charges;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nb_place;
    }

    public function setNbPlace(int $nb_place): static
    {
        $this->nb_place = $nb_place;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(\DateTimeInterface $date_ajout): static
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLocataire(): Collection
    {
        return $this->locataire;
    }

    public function addLocataire(User $locataire): static
    {
        if (!$this->locataire->contains($locataire)) {
            $this->locataire->add($locataire);
            $locataire->setLocationFK($this);
        }

        return $this;
    }

    public function removeLocataire(User $locataire): static
    {
        if ($this->locataire->removeElement($locataire)) {
            // set the owning side to null (unless already changed)
            if ($locataire->getLocationFK() === $this) {
                $locataire->setLocationFK(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->Owner;
    }

    public function setOwner(?User $Owner): static
    {
        $this->Owner = $Owner;

        return $this;
    }
}
