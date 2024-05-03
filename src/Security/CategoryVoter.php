<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Category;
use App\Entity\CategoryUser;
use Assert\Assertion;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class CategoryVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!$subject instanceof Category) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param Category $subject
     * @param TokenInterface $token
     * @return bool
     * @throws \Assert\AssertionFailedException
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        Assertion::isInstanceOf($subject, Category::class);

        $user = $token->getUser();

        if (!$user) {
            return false;
        }

        if (!$subject->getWriters()->filter(fn (CategoryUser $item) => $item->getUser() === $user)->first()) {
            return false;
        }

        return true;
    }
}
