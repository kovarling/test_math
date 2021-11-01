<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Currencies\Strategies;

class LocalCurrencyProvider extends CurrencyProvider
{
    public const ROOT_FOLDER = '/../../';

    public function __construct(string $location)
    {
        $this->setLocation($location);
    }

    /**
     * @throws \JsonException
     */
    public function getRates(): array
    {
        $ratesString = file_get_contents(dirname(__DIR__).self::ROOT_FOLDER.$this->getLocation());

        if (!$ratesString) {
            throw new \Exception('rates file not found');
        }

        $exchangeRates = json_decode($ratesString, true, 512, JSON_THROW_ON_ERROR);

        if (empty($exchangeRates['rates'])) {
            throw new \Exception('Failed to parse rates file');
        }

        return $exchangeRates['rates'];
    }
}
