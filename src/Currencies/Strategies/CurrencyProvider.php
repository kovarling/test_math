<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Currencies\Strategies;

abstract class CurrencyProvider implements CurrencyProviderInterface
{
    private string $location;

    public function __construct()
    {
        $this->location = $_ENV['RATES_LOCATION'];
    }

    public function getLocation(): string
    {
        return $this->location;
    }
}
