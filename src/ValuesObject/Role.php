<?php

declare(strict_types=1);

namespace App\ValuesObject;

use Assert\Assertion;
use Assert\AssertionFailedException;

final class Role implements \Stringable
{
    public const USER = 'ROLE_USER';
    public const ADMIN_CATEGORY = 'ROLE_ADMIN_CATEGORY';

    public const ALL = [
        self::USER,
        self::ADMIN_CATEGORY,
    ];

    /** @throws AssertionFailedException */
    public function __construct(private string $value)
    {
        Assertion::inArray($this->value, self::ALL);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
