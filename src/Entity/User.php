<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'locataire')]
    private ?Logements $LocationFK = null;

    /**
     * @var Collection<int, Logements>
     */
    #[ORM\OneToMany(targetEntity: Logements::class, mappedBy: 'Owner')]
    private Collection $ProprietaireFK;

    public function __construct()
    {
        $this->ProprietaireFK = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLocationFK(): ?Logements
    {
        return $this->LocationFK;
    }

    public function setLocationFK(?Logements $LocationFK): static
    {
        $this->LocationFK = $LocationFK;

        return $this;
    }

    /**
     * @return Collection<int, Logements>
     */
    public function getProprietaireFK(): Collection
    {
        return $this->ProprietaireFK;
    }

    public function addProprietaireFK(Logements $proprietaireFK): static
    {
        if (!$this->ProprietaireFK->contains($proprietaireFK)) {
            $this->ProprietaireFK->add($proprietaireFK);
            $proprietaireFK->setOwner($this);
        }

        return $this;
    }

    public function removeProprietaireFK(Logements $proprietaireFK): static
    {
        if ($this->ProprietaireFK->removeElement($proprietaireFK)) {
            // set the owning side to null (unless already changed)
            if ($proprietaireFK->getOwner() === $this) {
                $proprietaireFK->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * Trouve les utilisateurs qui ont uniquement le rôle ROLE_USER
     * @return User[] Returns an array of User objects
     */
    public function findStudentAccounts(): array
    {
        return $this->createQueryBuilder('u')
            ->where('u.roles = :emptyRoles OR u.roles = :userRole')
            ->setParameter('emptyRoles', '[]')
            ->setParameter('userRole', '["ROLE_USER"]')
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
