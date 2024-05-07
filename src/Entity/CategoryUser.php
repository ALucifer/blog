<?php

namespace App\Entity;

use App\ValuesObject\Roles;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'category_user')]
#[ORM\UniqueConstraint(fields: ['user', 'category'])]
class CategoryUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(type: 'roles', nullable: false)]
    private Roles $roles;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'writableCategories')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'writers')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private Category $category;

    public function __construct()
    {
        $this->roles = Roles::fromArray(['ROLE_WRITER']);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles->toRawArray();
    }

    public function roles(): Roles
    {
        return $this->roles;
    }

    public function setRoles(Roles $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
