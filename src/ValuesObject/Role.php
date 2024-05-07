<?php

declare(strict_types=1);

namespace App\ValuesObject;

use Assert\Assertion;
use Assert\AssertionFailedException;

final class Role implements \Stringable
{
    public const USER = 'ROLE_USER';
    public const ADMIN_CATEGORY = 'ROLE_ADMIN_CATEGORY';
    public const WRITER = 'ROLE_WRITER';
    public const ADMIN = 'ROLE_ADMIN';

    public const ALL = [
        self::USER,
        self::ADMIN_CATEGORY,
        self::WRITER,
        self::ADMIN,
    ];

    /** @throws AssertionFailedException */
    public function __construct(private string $value)
    {
        Assertion::inArray($this->value, self::ALL);
    }

    public static function user(): self
    {
        return new self(self::USER);
    }

    public static function adminCategory(): self
    {
        return new self(self::ADMIN_CATEGORY);
    }

    public static function writer(): self
    {
        return new self(self::WRITER);
    }

    public static function admin(): self
    {
        return new self(self::ADMIN);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
