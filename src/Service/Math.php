<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Service;

class Math
{
    private int $scale;

    public function __construct()
    {
        $this->scale = (int)$_ENV['BC_DEFAULT_SCALE'];
    }

    /**
     * @param int $scale
     */
    public function setScale(int $scale): void
    {
        $this->scale = $scale;
    }

    public function add(string $leftOperand, string $rightOperand): string
    {
        return bcadd($leftOperand, $rightOperand, $this->scale);
    }

    public function mul(string $leftOperand, string $rightOperand): string
    {
        return bcmul($leftOperand, $rightOperand, $this->scale);
    }

    public function div(string $leftOperand, string $rightOperand): string
    {
        return bcdiv($leftOperand, $rightOperand, $this->scale);
    }

    public function sub(string $leftOperand, string $rightOperand): string
    {
        return bcsub($leftOperand, $rightOperand, $this->scale);
    }

    public function comp(string $leftOperand, string $rightOperand): int
    {
        return bccomp($leftOperand, $rightOperand, $this->scale);
    }
}
