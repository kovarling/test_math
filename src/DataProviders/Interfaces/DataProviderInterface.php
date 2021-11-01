<?php

namespace Withdrawal\CommissionTask\DataProviders\Interfaces;

interface DataProviderInterface
{
    public function getDataIterable() : \Generator;
}