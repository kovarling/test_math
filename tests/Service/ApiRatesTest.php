<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use DI\Container;
use Dotenv\Dotenv;
use Withdrawal\CommissionTask\Currencies\Strategies\ApiCurrencyProvider;
use Withdrawal\CommissionTask\Currencies\Strategies\CurrencyProviderFactory;
use Withdrawal\CommissionTask\Currencies\Strategies\CurrencyProviderInterface;
use Withdrawal\CommissionTask\Scripts\MathScript;

class ApiRatesTest extends TestCase
{
    private const STRATEGY = 'api';

    private string $currencyToSearch;
    private CurrencyProviderFactory $currencyProviderFactory;

    public function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../', '.env.test');
        $dotenv->load();

        $testEnvStrategy = $_ENV['RATES_STRATEGY'];
        $_ENV['RATES_STRATEGY'] = self::STRATEGY;
        $this->currencyToSearch = $_ENV['RATES_BASE_CURRENCY'];

        $container = new Container();
        $this->currencyProviderFactory = $container->get(CurrencyProviderFactory::class);

        //Reset $_ENV for other tests if any
        $_ENV['RATES_STRATEGY'] = $testEnvStrategy;
    }

    public function testApiRates(): void
    {
        $currencyProvider = $this->currencyProviderFactory->getCurrencyProviderStrategy();

        $this->assertEquals(
            get_class($currencyProvider),
            ApiCurrencyProvider::class
        );

        $this->assertArrayHasKey(
            $this->currencyToSearch,
            $currencyProvider->getRates()
        );
    }

}