<?php

namespace App\Workflow;

use App\ValuesObject\CategoryUserState;
use App\ValuesObject\Role;
use App\ValuesObject\Roles;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;

final class UserRoleToApproveMarkingStore implements MarkingStoreInterface
{
    public function getMarking(object $subject): Marking
    {
        return new Marking([$subject->getState() => 1]);
    }

    public function setMarking(object $subject, Marking $marking, array $context = []): void
    {
        $marking = key($marking->getPlaces());

        $subject->setState($marking);

        $roles = match ($marking) {
            CategoryUserState::REJECTED->value => Roles::fromArray([(string) Role::noOne()]),
            CategoryUserState::APPROVED->value => Roles::fromArray([(string) Role::writer()]),
            default => throw new \LogicException('Not implemented.'),
        };

        $subject->setRoles($roles);
    }
}