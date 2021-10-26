<?php

declare(strict_types=1);


namespace Withdrawal\CommissionTask\Service;


use http\Client;

class CurrencyRates
{

    private array $rates = [];
    private bool $cached = false;
    private string $apiKey;
    private string $apiEndpoint;
    private string $baseCurrency;
    private Math $math;

    public function __construct(Math $math)
    {
        $this->math = $math;
        $this->apiKey = $_ENV['RATES_API_KEY'];
        $this->apiEndpoint = $_ENV['RATES_API_ENDPOINT'];
        $this->baseCurrency = $_ENV['RATES_BASE_CURRENCY'];
    }

    public function convertFromBaseCurrency(string $currency, string $amount) : string
    {
        return $this->math->mul($amount, (string)$this->getRateByCurrency($currency));
    }

    public function convertToBaseCurrency(string $currency, string $amount): string
    {
        return $this->math->div($amount, (string)$this->getRateByCurrency($currency));
    }

    /**
     * @param string $currency
     * @return mixed
     * @throws \Exception
     */
    private function getRateByCurrency(string $currency)
    {
        if(!$this->cached) {
            $this->downloadRates();
        }

        return $this->rates[$currency] ?? throw new \Exception("Currency $currency not supported");
    }

    /**
     * @throws \Exception
     */
    private function downloadRates() : void
    {
        // Example from exchangeratesapi.io with modifications
        // Initialize CURL:
        $ch = curl_init("http://api.exchangeratesapi.io/v1/{$this->apiEndpoint}?access_key={$this->apiKey}&base={$this->baseCurrency}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        if(empty($exchangeRates['rates'])) {
            throw new \Exception('Failed rates api response :'.$json);
        }

        // Access the exchange rate values, e.g. GBP:
        $this->rates = $exchangeRates['rates'];

        $this->cached = true;
    }
}