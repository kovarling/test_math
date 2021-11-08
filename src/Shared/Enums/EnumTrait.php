<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Shared\Enums;

trait EnumTrait
{
    public static function from(string $value): string
    {
        if (!in_array($value, static::getConstants(), true)) {
            throw new \InvalidArgumentException("$value is not a valid type");
        }

        return $value;
    }

    public static function getConstants(): array
    {
        $reflectionClass = new \ReflectionClass(static::class);

        return $reflectionClass->getConstants();
    }
}
