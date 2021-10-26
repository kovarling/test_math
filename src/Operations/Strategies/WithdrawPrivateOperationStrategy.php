<?php

declare(strict_types=1);


namespace Withdrawal\CommissionTask\Operations\Strategies;


use Withdrawal\CommissionTask\Operations\Models\Operation;
use Withdrawal\CommissionTask\Service\CurrencyRates;
use Withdrawal\CommissionTask\Service\Math;
use Withdrawal\CommissionTask\Service\RoundUpCurrency;
use Withdrawal\CommissionTask\Service\WeekDatesCalculator;

class WithdrawPrivateOperationStrategy extends AbstractOperationStrategy
{

    private string $freeLimit;
    private int $freeCount;

    private CurrencyRates $currencyRates;

    public function __construct(CurrencyRates $currencyRates, Math $math, RoundUpCurrency $roundUpCurrency, Operation $operation)
    {
        parent::__construct($math, $roundUpCurrency, $operation);

        $this->currencyRates = $currencyRates;
        $this->setFee($_ENV['WITHDRAW_PRIVATE_FEE']);
        $this->freeLimit = $_ENV['WITHDRAW_FREE_LIMIT'];
        $this->freeCount = (int)$_ENV['WITHDRAW_FREE_COUNT'];
    }

    /**
     *
     * Commission fee - 0.3% from withdrawn amount.
     * 1000.00 EUR for a week (from Monday to Sunday) is free of charge.
     * Only for the first 3 withdraw operations per a week.
     * 4th and the following operations are calculated by using the rule above (0.3%).
     * If total free of charge amount is exceeded them commission is calculated only for the exceeded amount
     * (i.e. up to 1000.00 EUR no commission fee is applied).
     *
     * @return float
     */
    public function calculateFee(): float
    {
        $operation = $this->getOperation();
        $client = $operation->getClient();
        $weekIndex = WeekDatesCalculator::getWeekIndexByDate($operation->getDate());

        $needConversion = $operation->getCurrency() !== $this->baseCurrency;
        if($needConversion) { // convert to base currency
            $amount = $this->currencyRates->convertToBaseCurrency(
                $operation->getCurrency(),
                $operation->getAmount()
            );
        } else {
            $amount = $operation->getAmount();
        }


        $operationsCountByWeek = $client->getWithdrawCountByWeek($weekIndex);
        $operationsAmountByWeek = $client->getWithdrawAmountByWeek($weekIndex);

        $client->addWithdrawOperationByWeek($weekIndex, $amount);

        if( // No free stuff
            $operationsCountByWeek >= $this->freeCount
            || $this->math->comp($operationsAmountByWeek, $this->freeLimit) === 1
        ) {
            return parent::calculateFee();
        }

        $amountForFee = $this->math->sub(
            $this->freeLimit,
            $this->math->add($operationsAmountByWeek, $amount)
        );

        if($needConversion) {
            $amountForFee = $this->currencyRates->convertFromBaseCurrency(
                $operation->getCurrency(),
                $amountForFee
            );
        }

        if($this->math->comp($amountForFee, '0') === -1) { // we are still in free-range
            return 0;
        } else {
            return $this->getRoundedUpCurrency(
                $this->math->mul($amountForFee, $this->getFee())
            );
        }

    }

}