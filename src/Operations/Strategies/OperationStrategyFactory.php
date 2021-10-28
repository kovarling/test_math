<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Operations\Strategies;

use Di\Container as Container;
use Withdrawal\CommissionTask\Operations\Interfaces\OperationStrategy;
use Withdrawal\CommissionTask\Operations\Models\Operation;

class OperationStrategyFactory
{
    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function getOperationStrategy(Operation $operation): OperationStrategy
    {
        $container = new Container();

        $classString =
            $operation->getOperationType()->name
            .$operation->getClient()->getClientType()->name
            .'OperationStrategy'
        ;

        return $container->make(__NAMESPACE__.'\\'.$classString, ['operation' => $operation]);
    }
}
