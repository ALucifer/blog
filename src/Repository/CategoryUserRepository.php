<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\CategoryUser;
use App\Entity\User;
use App\ValuesObject\Role;
use App\ValuesObject\Roles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoryUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryUser::class);
    }

    public function save(Category $category, User $user, Roles $roles = null)
    {
        $entity = new CategoryUser();
        $entity
            ->setUser($user)
            ->setCategory($category)
            ->setRoles($roles ?? Roles::fromArray([(string) Role::writer()]));

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(CategoryUser $element)
    {
        $this->getEntityManager()->remove($element);
        $this->getEntityManager()->flush();
    }
}