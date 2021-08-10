<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\Enum;

use ReflectionClass;

abstract class BaseEnum
{
    public static function all(): array
    {
        $reflection = new ReflectionClass(static::class);

        return $reflection->getConstants();
    }

    /**
     * @psalm-suppress MissingParamType
     */
    public static function contains($value): bool
    {
        return in_array($value, static::all(), true);
    }
}
