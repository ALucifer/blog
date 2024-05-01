<?php

namespace App\Entity;

use App\Repository\UserRepository;
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

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    public function posts(): Collection
    {
        return $this->posts;
    }

    public function setPosts(Collection $posts): void
    {
        $this->posts = $posts;
    }

    public function ownerCategories(): Collection
    {
        return $this->ownerCategories;
    }

    public function setOwnerCategories(Collection $ownerCategories): void
    {
        $this->ownerCategories = $ownerCategories;
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
    public function setWritableCategories(Collection $writableCategories): void
    {
        $this->writableCategories = $writableCategories;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
