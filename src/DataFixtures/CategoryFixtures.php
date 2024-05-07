<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\CategoryUser;
use App\ValuesObject\Role;
use App\ValuesObject\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $categoryA = new Category();
        $categoryA
            ->setName('Jeux vidéo')
            ->setOwner($this->getReference(UserFixtures::ADMIN));

        $categoryB = new Category();
        $categoryB
            ->setName('Actualités')
            ->setOwner($this->getReference(UserFixtures::ADMIN));

        $manager->persist($categoryA);
        $manager->persist($categoryB);

        $categoryUserA = new CategoryUser();
        $categoryUserA
            ->setCategory($categoryA)
            ->setUser($this->getReference(UserFixtures::ADMIN))
            ->setRoles(Roles::fromArray([(string) Role::adminCategory()]));

        $categoryUserB = new CategoryUser();
        $categoryUserB
            ->setCategory($categoryB)
            ->setUser($this->getReference(UserFixtures::ADMIN))
            ->setRoles(Roles::fromArray([(string) Role::adminCategory()]));

        $manager->persist($categoryUserA);
        $manager->persist($categoryUserB);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
