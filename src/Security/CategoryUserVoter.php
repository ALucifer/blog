<?php

namespace App\Security;

use App\Entity\CategoryUser;
use App\Entity\User;
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
        return match ($attribute) {
            'user' => $this->user($subject, $token),
            'admin' => $this->admin($subject, $token),
            default => throw new \LogicException(sprintf('Rule %s in Category user voter not implemented.'), $attribute),
        };

    }

    private function user(CategoryUser $categoryUser, TokenInterface $token): bool
    {
        if (!$token->getUser()) {
            return false;
        }

        return $categoryUser->getUser() === $token->getUser();
    }

    private function admin(CategoryUser $categoryUser, TokenInterface $token): bool
    {
        /** @var User $authenticatedUser */
        $authenticatedUser = $token->getUser();

        return $authenticatedUser->ownerCategories()->contains($categoryUser->getCategory());
    }
}
