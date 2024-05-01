<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use App\ValuesObject\Roles;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

final class RolesType extends JsonType
{
    private const TYPE = 'roles';

    /**
     * @param Roles $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return parent::convertToDatabaseValue($value->toRawArray(), $platform);
    }

    /**
     * @param array<int, string> $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Roles
    {
        /** @var array<int, string> $roles */
        $roles = parent::convertToPHPValue($value, $platform) ?? [];

        return Roles::fromArray($roles);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
