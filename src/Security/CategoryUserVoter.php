<?php

namespace App\Security;

use App\Entity\CategoryUser;
use App\ValuesObject\Role;
use Assert\Assertion;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CategoryUserVoter extends Voter
{

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $subject instanceof CategoryUser;
    }

    /**
     * @param CategoryUser $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        Assertion::isInstanceOf($subject, CategoryUser::class);

        return $subject->roles()->contains(Role::adminCategory());
    }
}