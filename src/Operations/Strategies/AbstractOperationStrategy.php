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
        Operation $operation
    )
    {
        $this->roundUpCurrency = $roundUpCurrency;
        $this->operation = $operation;
        $this->baseCurrency = $_ENV['RATES_BASE_CURRENCY'];
        $this->math = $math;
    }

    /**
     * @param string $fee
     */
    public function setFee(string $fee): void
    {
        $this->fee = $fee;
    }

    /**
     * @return string
     */
    public function getFee(): string
    {
        return $this->fee;
    }


    /**
     * @return Operation
     */
    public function getOperation(): Operation
    {
        return $this->operation;
    }

    /**
     * @return float
     */
    public function getRoundedUpCurrency(string $amount): float
    {
        return $this->roundUpCurrency->roundUp((float)$amount);
    }

    public function calculateFee(): float
    {
        return $this->getRoundedUpCurrency(
            $this->math->mul($this->getOperation()->getAmount(), $this->fee)
        );
    }
}