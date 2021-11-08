<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Users\Enums;

use Withdrawal\CommissionTask\Common\Enums\EnumTrait;

class ClientType
{
    use EnumTrait;

    public const BUSINESS = 'business';
    public const PRIVATE = 'private';
}
