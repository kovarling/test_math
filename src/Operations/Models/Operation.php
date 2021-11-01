<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Operations\Models;

use Withdrawal\CommissionTask\Operations\Enums\OperationType;
use Withdrawal\CommissionTask\Users\Models\Client;

class Operation
{
    private string $currency;
    private Client $client;
    private \DateTimeImmutable $date;
    private string $amount;
    private OperationType $operationType;
    private int $decimalsCount;

    public function __construct(
        string $currency,
        Client $client,
        \DateTimeImmutable $date,
        string $amount,
        OperationType $operationType
    ) {
        $this->client = $client;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->date = $date;
        $this->operationType = $operationType;
        $this->decimalsCount = $this->calculateDecimalsCount($amount);
    }

    private function calculateDecimalsCount(string $amount): int
    {
        $dotPos = strpos($amount, '.');
        if ($dotPos === false) {
            return 0;
        } else {
            return strlen(substr($amount, $dotPos + 1)); // +1 because we don't need to count dot in substr
        }
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

    public function getOperationType(): OperationType
    {
        return $this->operationType;
    }

    public function getDecimalsCount(): int
    {
        return $this->decimalsCount;
    }
}
