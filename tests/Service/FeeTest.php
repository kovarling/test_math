<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use DI\Container;
use Dotenv\Dotenv;
use Withdrawal\CommissionTask\Scripts\MathScript;

class FeeTest extends TestCase
{
    private Container $container;

    public function setUp(): void
    {
        $this->container = new Container();

        $dotenv = Dotenv::createImmutable(__DIR__.'/../../docker', '.env.test');
        $dotenv->load();

    }

    /**
     * @dataProvider dataProviderForFeeCalcTesting
     */
    public function testFeeCalculation(string $csvFile, array $expectedResult): void
    {

        $mathScript = $this->container->get(MathScript::class);
        $scriptResult = [];
        foreach ($mathScript->perform($csvFile) as $line) {
            $scriptResult[] = $line;
        }
        $this->assertEquals(
            $scriptResult,
            $expectedResult,
            "difference: ".json_encode(array_diff($expectedResult, $scriptResult))
        );
    }

    public function dataProviderForFeeCalcTesting() : array
    {
        return [
            'test data from task' => [
                '/../../input_test/batch.csv',
                [
                    '0.60',
                    '3.00',
                    '0.00',
                    '0.06',
                    '1.50',
                    '0',
                    '0.70',
                    '0.30',
                    '0.30',
                    '3.00',
                    '0.00',
                    '0.00',
                    '8612',
                ],
            ]
        ];
    }

}