<?php

namespace App\ValuesObject;

enum CategoryUserState: string
{
    case WAITING = 'waiting_approve';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case REMOVED = 'removed';
}
