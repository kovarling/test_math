<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Users\Enums;

enum ClientType : string
{
    case Business = 'business';
    case Private = 'private';
}
