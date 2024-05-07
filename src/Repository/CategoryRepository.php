<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use App\Entity\CategoryUser;
use App\Entity\User;
use App\ValuesObject\Role;
use App\ValuesObject\Roles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

final class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private Security $security)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $category): void
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $category->setOwner($user);

        $categoryUser = new CategoryUser();
        $categoryUser
            ->setCategory($category)
            ->setUser($user)
            ->setRoles(Roles::fromArray([(string) Role::adminCategory()]));

        $category->addWriter($categoryUser);

        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->persist($categoryUser);
        $this->getEntityManager()->flush();
    }
}
