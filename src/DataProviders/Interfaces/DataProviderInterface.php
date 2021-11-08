<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\DataProviders\Interfaces;

interface DataProviderInterface
{
    public function getDataIterable(): \Generator;
}
