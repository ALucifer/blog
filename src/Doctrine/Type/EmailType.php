<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class EmailType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        $platform->getStringTypeDeclarationSQL($column);
    }

    public function getName()
    {
        return 'email';
    }
}
