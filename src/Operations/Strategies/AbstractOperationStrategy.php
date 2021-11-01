<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Operations\Strategies;

use Withdrawal\CommissionTask\Operations\Interfaces\OperationStrategy;
use Withdrawal\CommissionTask\Operations\Models\Operation;
use Withdrawal\CommissionTask\Service\Math;
use Withdrawal\CommissionTask\Service\RoundUpCurrency;

abstract class AbstractOperationStrategy implements OperationStrategy
{
    private string $fee = '0';
    public string $baseCurrency;

    private Operation $operation;
    private RoundUpCurrency $roundUpCurrency;
    public Math $math;

    public function __construct(
        Math $math,
        RoundUpCurrency $roundUpCurrency,
        string $baseCurrency
    ) {
        $this->roundUpCurrency = $roundUpCurrency;
        $this->baseCurrency = $baseCurrency;
        $this->math = $math;
    }

    public function setOperation(Operation $operation): void
    {
        $this->operation = $operation;
    }

    public function setFee(string $fee): void
    {
        $this->fee = $fee;
    }

    public function getFee(): string
    {
        return $this->fee;
    }

    public function getOperation(): Operation
    {
        return $this->operation;
    }

    public function getRoundedUpCurrency(string $amount): float
    {
        return $this->roundUpCurrency->roundUp((float) $amount);
    }

    public function calculateFee(): float
    {
        return $this->getRoundedUpCurrency(
            $this->math->mul($this->getOperation()->getAmount(), $this->fee)
        );
    }
}
