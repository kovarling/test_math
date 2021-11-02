<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Currencies\Strategies;

use Withdrawal\CommissionTask\Currencies\Exceptions\RatesException;

interface CurrencyProviderInterface
{
    /**
     * @throws \JsonException
     * @throws RatesException
     */
    public function getRates(): array;
}
