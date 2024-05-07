<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[UniqueEntity('name', message: 'Nom déjà utilisé.')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    #[Assert\Length(min: 5, max: 50, maxMessage: 'Nom trop long', minMessage: 'Trop court')]
    private string $name;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'categories')]
    private User $owner;

    #[ORM\OneToMany(targetEntity: CategoryUser::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $writers;

    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'category')]
    private Collection $posts;

    public function __construct()
    {
        $this->writers = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function owner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getWriters(): Collection
    {
        return $this->writers;
    }

    public function addWriter(CategoryUser $writer): self
    {
        if(!$this->writers->contains($writer)) {
            $this->writers->add($writer);
            $writer->setCategory($this);
        }

        return $this;
    }

    public function removeWriter(CategoryUser $writer): self
    {
        $this->writers->removeElement($writer);

        return $this;
    }

    public function posts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setCategory($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->posts->removeElement($post);

        return $this;
    }
}
