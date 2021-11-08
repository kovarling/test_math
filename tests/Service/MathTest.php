<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use Withdrawal\CommissionTask\Common\Service\Math;

class MathTest extends TestCase
{
    /**
     * @var Math
     */
    private Math $math;

    public function setUp() : void
    {
        $this->math = new Math(2);
    }

    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $expectation
     *
     * @dataProvider dataProviderForAddTesting
     */
    public function testAdd(string $leftOperand, string $rightOperand, int $roundingScale, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->math->round($this->math->add($leftOperand, $rightOperand), $roundingScale)
        );
    }

    public function dataProviderForAddTesting(): array
    {
        return [
            'add 2 natural numbers' => ['1', '2', 0, '3'],
            'add negative number to a positive' => ['-1', '2', 0, '1'],
            'add natural number to a float' => ['1', '1.05123', 2, '2.05'],
        ];
    }
}
