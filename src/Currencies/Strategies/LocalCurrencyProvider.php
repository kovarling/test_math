<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Currencies\Strategies;

class LocalCurrencyProvider extends CurrencyProvider
{
    public function getRates(): array
    {
        $ratesString = file_get_contents(dirname(__DIR__).'/../../'.$this->getLocation());

        if (!$ratesString) {
            throw new \Exception('rates file not found');
        }

        $exchangeRates = json_decode($ratesString, true);

        if (empty($exchangeRates['rates'])) {
            throw new \Exception('Failed to parse rates file');
        }

        return $exchangeRates['rates'];
    }
}
