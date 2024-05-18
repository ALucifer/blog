<?php

namespace App\ValuesObject;

enum CategoryUserState: string
{
    case WAITING = 'waiting_approve';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case REMOVED = 'removed';

    public function toTransition(): string
    {
        return match ($this) {
            self::REJECTED => 'to_rejected',
            self::APPROVED => 'to_approved',
            default => throw new \LogicException('Transition not implemented'),
        };
    }
}
