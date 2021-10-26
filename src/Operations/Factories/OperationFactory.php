<?php

declare(strict_types=1);


namespace Withdrawal\CommissionTask\Operations\Factories;


use Withdrawal\CommissionTask\Operations\Enums\OperationType;
use Withdrawal\CommissionTask\Operations\Models\Operation;
use Withdrawal\CommissionTask\Users\Models\Client;

class OperationFactory
{
    /**
     * @param string $dateString
     * @param string $typeString
     * @param string $amountString
     * @param string $currencyString
     * @param Client $client
     * @return Operation
     * @throws \Exception
     */
    public static function create(
        string $dateString,
        string $typeString,
        string $amountString,
        string $currencyString,
        Client $client
    ) : Operation
    {
        return new Operation(
            strtoupper(trim($currencyString)),
            $client,
            new \DateTimeImmutable($dateString),
            $amountString,
            OperationType::from($typeString)
        );
    }
}