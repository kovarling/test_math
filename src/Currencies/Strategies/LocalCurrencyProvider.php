<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Currencies\Strategies;

use Withdrawal\CommissionTask\Currencies\Exceptions\RatesException;

class LocalCurrencyProvider extends CurrencyProvider
{
    public const ROOT_FOLDER = '/../../';

    public function __construct(string $location)
    {
        $this->setLocation($location);
    }

    /**
     * @throws RatesException
     * @throws \JsonException
     */
    public function getRates(): array
    {
        $ratesString = file_get_contents(dirname(__DIR__).self::ROOT_FOLDER.$this->getLocation());

        if (!$ratesString) {
            throw new RatesException('rates file not found');
        }

        $exchangeRates = json_decode($ratesString, true, 512, JSON_THROW_ON_ERROR);

        if (empty($exchangeRates['rates'])) {
            throw new RatesException('Failed to parse rates file');
        }

        return $exchangeRates['rates'];
    }
}
