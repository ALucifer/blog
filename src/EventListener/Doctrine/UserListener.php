<?php

namespace App\EventListener\Doctrine;

use App\Entity\User;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Mapping\PrePersist;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    #[PrePersist]
    public function prePersistHandler(User $user, PrePersistEventArgs $event): void
    {
        if (!$user->getId()) {
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $user->getPassword())
            );
        }
    }
}