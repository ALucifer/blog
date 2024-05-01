<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Post;
use App\Entity\User;
use Assert\Assertion;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class PostVoter extends Voter
{

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!\in_array($attribute, ['edit']) || !$subject instanceof Post) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        Assertion::isInstanceOf($subject, Post::class);
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        return $user === $subject->owner();
    }
}
