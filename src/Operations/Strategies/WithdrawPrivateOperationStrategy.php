<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Operations\Strategies;

use Withdrawal\CommissionTask\Service\CurrencyRates;
use Withdrawal\CommissionTask\Service\Math;
use Withdrawal\CommissionTask\Service\RoundUpCurrency;
use Withdrawal\CommissionTask\Service\WeekDatesCalculator;

class WithdrawPrivateOperationStrategy extends AbstractOperationStrategy
{
    private string $freeLimit;
    private int $freeCount;

    private CurrencyRates $currencyRates;
    private WeekDatesCalculator $weekDatesCalculator;

    public function __construct(
        CurrencyRates $currencyRates,
        Math $math,
        RoundUpCurrency $roundUpCurrency,
        WeekDatesCalculator $weekDatesCalculator,
        string $baseCurrency,
        string $fee,
        string $freeLimit,
        int $freeCount
    ) {
        parent::__construct($math, $roundUpCurrency, $baseCurrency);

        $this->currencyRates = $currencyRates;
        $this->setFee($fee);
        $this->freeLimit = $freeLimit;
        $this->freeCount = $freeCount;
        $this->weekDatesCalculator = $weekDatesCalculator;
    }

    /**
     * Commission fee - 0.3% from withdrawn amount.
     * 1000.00 EUR for a week (from Monday to Sunday) is free of charge.
     * Only for the first 3 withdraw operations per a week.
     * 4th and the following operations are calculated by using the rule above (0.3%).
     * If total free of charge amount is exceeded them commission is calculated only for the exceeded amount
     * (i.e. up to 1000.00 EUR no commission fee is applied).
     *
     * @throws
     */
    public function calculateFee(): float
    {
        $operation = $this->getOperation();
        $client = $operation->getClient();
        $weekIndex = $this->weekDatesCalculator->getWeekIndexByDate($operation->getDate());

        $needConversion = $operation->getCurrency() !== $this->baseCurrency;
        if ($needConversion) { // convert to base currency
            $amount = $this->currencyRates->convertToBaseCurrency(
                $operation->getCurrency(),
                $operation->getAmount(),
                $operation->getDecimalsCount()
            );
        } else {
            $amount = $operation->getAmount();
        }

        $operationsCountByWeek = $client->getWithdrawCountByWeek($weekIndex);
        $operationsAmountByWeek = $client->getWithdrawAmountByWeek($weekIndex);

        $client->setWithdrawOperationByWeek(
            $weekIndex,
            $this->math->add(
                $operationsAmountByWeek,
                $amount
            )
        );

        if ( // No free stuff
            $operationsCountByWeek >= $this->freeCount
            || $this->math->comp($operationsAmountByWeek, $this->freeLimit) === 1
        ) {
            return parent::calculateFee();
        }

        $amountForFee = $this->math->sub(
            $this->math->add($operationsAmountByWeek, $amount),
            $this->freeLimit
        );

        if ($needConversion) {
            $amountForFee = $this->currencyRates->convertFromBaseCurrency(
                $operation->getCurrency(),
                $amountForFee,
                $operation->getDecimalsCount()
            );
        }

        if ($this->math->comp($amountForFee, '0') === -1) { // we are still in free-range
            return 0;
        } else {
            return $this->getRoundedUpCurrency(
                $this->math->mul($amountForFee, $this->getFee())
            );
        }
    }
}
