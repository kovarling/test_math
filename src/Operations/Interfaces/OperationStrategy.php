<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Operations\Interfaces;

use Withdrawal\CommissionTask\Operations\Models\Operation;

interface OperationStrategy
{
    public function setOperation(Operation $operation): void;

    public function calculateFee(): float;
}
