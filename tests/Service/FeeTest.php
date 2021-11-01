<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Tests\Service;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use DI\Container;
use Dotenv\Dotenv;
use Withdrawal\CommissionTask\Scripts\MathScript;

class FeeTest extends TestCase
{
    private Container $container;

    public function setUp(): void
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions(__DIR__ . '/../../config/config.php');
        $containerBuilder->useAnnotations(true);
        $this->container = $containerBuilder->build();

        $dotenv = Dotenv::createImmutable(__DIR__.'/../../', '.env.test');
        $dotenv->load();

    }

    /**
     * @dataProvider dataProviderForFeeCalcTesting
     */
    public function testFeeCalculation(array $expectedResult): void
    {
        $mathScript = $this->container->get(MathScript::class);
        $scriptResult = [];
        foreach ($mathScript->perform() as $line) {
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