<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\CategoryUser;
use App\Entity\User;
use App\ValuesObject\CategoryUserState;
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

    public function create(Category $category, User $user): void
    {
        $entity = new CategoryUser();
        $entity
            ->setUser($user)
            ->setCategory($category)
            ->setState(CategoryUserState::WAITING->value)
            ->setRoles(Roles::fromArray([(string) Role::waitingApprovement()]));

        $this->save($entity);
    }

    public function save(CategoryUser $categoryUser): void
    {
        $this->getEntityManager()->persist($categoryUser);
        $this->getEntityManager()->flush();
    }

    public function remove(CategoryUser $element): void
    {
        $this->getEntityManager()->remove($element);
        $this->getEntityManager()->flush();
    }

    public function getWaitingAccess(User $user): array
    {
        return $this->findBy([
            'user' => $user,
            'state' => CategoryUserState::WAITING
        ]);
    }
}
