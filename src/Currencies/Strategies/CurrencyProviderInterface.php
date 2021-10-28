<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Currencies\Strategies;

interface CurrencyProviderInterface
{
    /**
     * @throws \Exception
     */
    public function getRates(): array;
}
