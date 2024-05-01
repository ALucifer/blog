<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use App\Entity\User;
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

        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
    }
}
