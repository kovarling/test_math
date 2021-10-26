<?php

namespace Withdrawal\CommissionTask\Operations\Interfaces;

interface OperationStrategy
{

    public function calculateFee(): float;

}