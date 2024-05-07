<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\ValuesObject\Role;
use App\ValuesObject\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const ADMIN = 'user_admin';

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user
            ->setEmail('admin@mail.com')
            ->setPassword('password')
            ->setPseudo('admin')
            ->setRoles(
                Roles::fromArray(
                    [
                        (string) Role::admin()
                    ]
                )
            );

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::ADMIN, $user);
    }
}
