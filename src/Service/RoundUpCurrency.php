<?php

declare(strict_types=1);


namespace Withdrawal\CommissionTask\Service;


class RoundUpCurrency
{
    private int $precision;

    public function __construct(int $precision = 2)
    {
        $this->precision = $precision;
    }

    /**
     * @return int
     */
    public function getPrecision(): int
    {
        return $this->precision;
    }

    /**
     * @param int $precision
     */
    public function setPrecision(int $precision): void
    {
        $this->precision = $precision;
    }


    public function roundUp(float $number) : float
    {
        $fig = pow(10, $this->precision);
        return (ceil($number * $fig) / $fig);
    }
}