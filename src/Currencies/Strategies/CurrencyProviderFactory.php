<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Currencies\Strategies;

use DI\Container;

class CurrencyProviderFactory
{
    private string $strategyClass;
    private Container $container;

    public function __construct(Container $container)
    {
        $this->strategyClass = $_ENV['RATES_STRATEGY'];
        $this->container = $container;
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function getCurrencyProviderStrategy(): CurrencyProviderInterface
    {
        $classString =
            ucfirst($this->strategyClass)
            .'CurrencyProvider'
        ;

        return $this->container->make(__NAMESPACE__.'\\'.$classString, []);
    }
}
