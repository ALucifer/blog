<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\ValuesObject\Roles;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    private string $email;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $password;

    #[ORM\Column(type: 'string', length: 50)]
    private string $pseudo;

    #[ORM\Column(type: 'roles', nullable: false)]
    private Roles $roles;

    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'owner')]
    private Collection $posts;

    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'owner', cascade: ['persist'])]
    private Collection $ownerCategories;

    #[ORM\OneToMany(targetEntity: CategoryUser::class, mappedBy: 'user')]
    private Collection $writableCategories;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->ownerCategories = new ArrayCollection();
        $this->writableCategories = new ArrayCollection();
        $this->roles = Roles::fromArray(['ROLE_USER']);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function posts(): Collection
    {
        return $this->posts;
    }

    public function setPosts(Collection $posts): self
    {
        $this->posts = $posts;

        return $this;
    }

    public function ownerCategories(): Collection
    {
        return $this->ownerCategories;
    }

    public function setOwnerCategories(Collection $ownerCategories): self
    {
        $this->ownerCategories = $ownerCategories;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getWritableCategories(): Collection
    {
        return $this->writableCategories;
    }

    /**
     * @param Collection $writableCategories
     */
    public function setWritableCategories(Collection $writableCategories): self
    {
        $this->writableCategories = $writableCategories;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return $this->roles->toRawArray();
    }

    public function setRoles(Roles $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
