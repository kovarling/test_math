<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Currencies\Strategies;

abstract class CurrencyProvider implements CurrencyProviderInterface
{
    private string $location;

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }
}
