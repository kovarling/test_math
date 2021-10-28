<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Operations\Strategies;

use Di\Container as Container;
use Withdrawal\CommissionTask\Operations\Interfaces\OperationStrategy;
use Withdrawal\CommissionTask\Operations\Models\Operation;

class OperationStrategyFactory
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function getOperationStrategy(Operation $operation): OperationStrategy
    {
        $classString =
            $operation->getOperationType()->name
            .$operation->getClient()->getClientType()->name
            .'OperationStrategy'
        ;

        return $this->container->make(__NAMESPACE__.'\\'.$classString, ['operation' => $operation]);
    }
}
