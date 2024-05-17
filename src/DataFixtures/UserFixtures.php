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
        $admin = new User();

        $admin
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

        $user = new User();
        $user
            ->setEmail('test@test.com')
            ->setPassword('test')
            ->setPseudo('test')
            ->setRoles(
                Roles::fromArray(
                    [
                        (string) Role::user()
                    ]
                )
            );


        $manager->persist($admin);
        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::ADMIN, $admin);
    }
}
