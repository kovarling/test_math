<?php

declare(strict_types=1);


namespace Withdrawal\CommissionTask\Service;

use Withdrawal\CommissionTask\Currencies\Strategies\CurrencyProviderFactory;

class CurrencyRates
{

    private array $rates = [];
    private bool $cached = false;
    private Math $math;
    private CurrencyProviderFactory $currencyProvider;

    public function __construct(Math $math, CurrencyProviderFactory $currencyProvider)
    {
        $this->math = $math;
        $this->apiKey = $_ENV['RATES_API_KEY'];
        $this->apiEndpoint = $_ENV['RATES_API_ENDPOINT'];
        $this->baseCurrency = $_ENV['RATES_BASE_CURRENCY'];
        $this->currencyProvider = $currencyProvider;
    }

    /**
     * @param string $currency
     * @param string $amount
     * @return string
     * @throws \Exception
     */
    public function convertFromBaseCurrency(string $currency, string $amount, ?int $scale = null) : string
    {
        $val = $this->math->mul($amount, (string)$this->getRateByCurrency($currency));

        if($scale !== null) {
            $val = $this->math->round($val, $scale);
        }

        return $val;
    }

    /**
     * @param string $currency
     * @param string $amount
     * @return string
     * @throws \Exception
     */
    public function convertToBaseCurrency(string $currency, string $amount, ?int $scale = null): string
    {
        $val = $this->math->div($amount, (string)$this->getRateByCurrency($currency));

        if($scale !== null) {
            $val = $this->math->round($val, $scale);
        }

        return $val;
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
        $this->rates = $this->currencyProvider->getCurrencyProviderStrategy()->getRates();
        $this->cached = true;
    }
}