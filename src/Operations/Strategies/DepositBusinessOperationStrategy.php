<?php

declare(strict_types=1);


namespace Withdrawal\CommissionTask\Operations\Strategies;


use Withdrawal\CommissionTask\Operations\Models\Operation;
use Withdrawal\CommissionTask\Service\Math;
use Withdrawal\CommissionTask\Service\RoundUpCurrency;

class DepositBusinessOperationStrategy extends AbstractOperationStrategy
{

    public function __construct(Math $math, RoundUpCurrency $roundUpCurrency, Operation $operation)
    {
        parent::__construct($math, $roundUpCurrency, $operation);
        $this->setFee($_ENV['DEPOSIT_BUSINESS_FEE']);
    }
}