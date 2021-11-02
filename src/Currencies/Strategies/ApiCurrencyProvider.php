<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Currencies\Strategies;

use Withdrawal\CommissionTask\Currencies\Exceptions\RatesException;

class ApiCurrencyProvider extends CurrencyProvider
{
    private string $apiEndpoint;
    private string $apiKey;
    private string $baseCurrency;

    public function __construct(
        string $location,
        string $baseCurrency,
        string $apiKey,
        string $apiEndpoint
    ) {
        $this->setLocation($location);
        $this->baseCurrency = $baseCurrency;
        $this->apiKey = $apiKey;
        $this->apiEndpoint = $apiEndpoint;
    }

    /**
     * @throws RatesException
     * @throws \JsonException
     */
    public function getRates(): array
    {
        // Example from exchangeratesapi.io with modifications
        // Initialize CURL:
        $ch = curl_init("{$this->getLocation()}{$this->apiEndpoint}?access_key={$this->apiKey}&base={$this->baseCurrency}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $exchangeRates = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        if (empty($exchangeRates['rates'])) {
            throw new RatesException('Failed rates api response :'.$json);
        }

        return $exchangeRates['rates'];
    }
}
