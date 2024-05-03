<?php

declare(strict_types=1);

namespace App\ValuesObject;


final class Roles extends Collection
{
    public static function itemType(): string
    {
        return Role::class;
    }

    public function toRawArray(): array
    {
        return \array_values(
            \array_map(
                static fn (Role $role): string => (string) $role,
                (array) $this->sort()->getIterator(),
            ),
        );
    }
}
