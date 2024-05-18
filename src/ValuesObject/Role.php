<?php

declare(strict_types=1);

namespace App\ValuesObject;

use Assert\Assertion;
use Assert\AssertionFailedException;

final class Role implements \Stringable
{
    public const ADMIN = 'ROLE_ADMIN';
    public const ADMIN_CATEGORY = 'ROLE_ADMIN_CATEGORY';
    public const USER = 'ROLE_USER';
    public const WAITING_APPROVEMENT = 'ROLE_WAITING_APPROVEMENT';
    public const NO_ONE = 'ROLE_NO_ONE';
    public const WRITER = 'ROLE_WRITER';

    public const ALL = [
        self::ADMIN,
        self::ADMIN_CATEGORY,
        self::NO_ONE,
        self::USER,
        self::WAITING_APPROVEMENT,
        self::WRITER,
    ];

    /** @throws AssertionFailedException */
    public function __construct(private string $value)
    {
        Assertion::inArray($this->value, self::ALL);
    }

    public static function admin(): self
    {
        return new self(self::ADMIN);
    }

    public static function adminCategory(): self
    {
        return new self(self::ADMIN_CATEGORY);
    }

    public static function noOne(): self
    {
        return new self(self::NO_ONE);
    }

    public static function user(): self
    {
        return new self(self::USER);
    }

    public static function waitingApprovement(): self
    {
        return new self(self::WAITING_APPROVEMENT);
    }

    public static function writer(): self
    {
        return new self(self::WRITER);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
