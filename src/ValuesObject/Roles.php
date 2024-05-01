<?php

declare(strict_types=1);

namespace App\ValuesObject;

final class Roles extends Collection
{
    public static function itemType(): string
    {
        return Role::class;
    }
}
