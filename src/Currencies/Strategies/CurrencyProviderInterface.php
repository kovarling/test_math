<?php

namespace Withdrawal\CommissionTask\Currencies\Strategies;

interface CurrencyProviderInterface
{

    /**
     * @return array
     * @throws \Exception
     */
    public function getRates() : array;

}