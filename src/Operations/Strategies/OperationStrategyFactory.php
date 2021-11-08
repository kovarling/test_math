<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Operations\Strategies;

use DI\DependencyException;
use Withdrawal\CommissionTask\Operations\Interfaces\OperationStrategy;
use Withdrawal\CommissionTask\Operations\Models\Operation;

class OperationStrategyFactory
{
    /** @var OperationStrategy[] */
    private array $knownStrategies = [];

    public function __construct(
        DepositBusinessOperationStrategy $depositBusinessOperationStrategy,
        DepositPrivateOperationStrategy $depositPrivateOperationStrategy,
        WithdrawBusinessOperationStrategy $withdrawBusinessOperationStrategy,
        WithdrawPrivateOperationStrategy $withdrawPrivateOperationStrategy
    ) {
        $this->knownStrategies = [
            (new \ReflectionClass($depositBusinessOperationStrategy))->getShortName() => $depositBusinessOperationStrategy,
            (new \ReflectionClass($depositPrivateOperationStrategy))->getShortName() => $depositPrivateOperationStrategy,
            (new \ReflectionClass($withdrawBusinessOperationStrategy))->getShortName() => $withdrawBusinessOperationStrategy,
            (new \ReflectionClass($withdrawPrivateOperationStrategy))->getShortName() => $withdrawPrivateOperationStrategy,
        ];
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function getOperationStrategy(Operation $operation): OperationStrategy
    {
        $classString =
            ucfirst($operation->getOperationType())
            .ucfirst($operation->getClient()->getClientType())
            .'OperationStrategy'
        ;

        if (!isset($this->knownStrategies[$classString])) {
            throw new DependencyException('Unknown Operation strategy: '.$classString);
        }

        $strategy = $this->knownStrategies[$classString];
        $strategy->setOperation($operation);

        return $strategy;
    }
}
