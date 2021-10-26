<?php

declare(strict_types=1);


namespace Withdrawal\CommissionTask\Operations\Enums;


enum OperationType : string
{
    case Withdraw = 'withdraw';
    case Deposit = 'deposit';
}