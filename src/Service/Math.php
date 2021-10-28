<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Service;

class Math
{
    private int $scale;

    public function __construct(?int $scale = null)
    {
        $this->scale = $scale ?? (int) $_ENV['BC_DEFAULT_SCALE'];
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

    /**
     * Rounding calculation values, based on https://stackoverflow.com/a/60794566/3212936.
     */
    public function round(string $valueToRound, int $scale): string
    {
        $result = $valueToRound;

        if (strpos($valueToRound, '.') !== false) {
            if ($valueToRound[0] !== '-') {
                $result = bcadd($valueToRound, '0.'.str_repeat('0', $scale).'5', $scale);
            } else {
                $result = bcsub($valueToRound, '0.'.str_repeat('0', $scale).'5', $scale);
            }
        }

        return $result;
    }
}
