<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Operations\Models;

use Withdrawal\CommissionTask\Users\Models\Client;

class Operation
{
    private string $currency;
    private Client $client;
    private \DateTimeImmutable $date;
    private string $amount;
    private string $operationType;
    private int $decimalsCount;

    public function __construct(
        string $currency,
        Client $client,
        \DateTimeImmutable $date,
        string $amount,
        string $operationType,
        int $decimalsCount
    ) {
        $this->client = $client;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->date = $date;
        $this->operationType = $operationType;
        $this->decimalsCount = $decimalsCount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getOperationType(): string
    {
        return $this->operationType;
    }

    public function getDecimalsCount(): int
    {
        return $this->decimalsCount;
    }
}
