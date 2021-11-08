<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Operations\Enums;

use Withdrawal\CommissionTask\Common\Enums\EnumTrait;

class OperationType
{
    use EnumTrait;

    public const WITHDRAW = 'withdraw';
    public const DEPOSIT = 'deposit';
}
