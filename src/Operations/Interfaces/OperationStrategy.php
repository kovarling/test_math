<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Operations\Interfaces;

interface OperationStrategy
{
    public function calculateFee(): float;
}
