<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Currencies\Strategies;

class ApiCurrencyProvider extends CurrencyProvider
{
    private string $apiEndpoint;
    private string $apiKey;
    private string $baseCurrency;

    public function __construct()
    {
        $this->setLocation($_ENV['RATES_LOCATION_API']);
        $this->baseCurrency = $_ENV['RATES_BASE_CURRENCY'];
        $this->apiKey = $_ENV['RATES_API_KEY'];
        $this->apiEndpoint = $_ENV['RATES_API_ENDPOINT'];
    }

    /**
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
            throw new \Exception('Failed rates api response :'.$json);
        }

        return $exchangeRates['rates'];
    }
}
