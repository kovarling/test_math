<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Users\Models;

use Withdrawal\CommissionTask\Service\Math;
use Withdrawal\CommissionTask\Users\Enums\ClientType;

class Client
{
    private array $withdrawOperations;

    private int $id;
    private ClientType $clientType;
    private Math $math;

    public function __construct(Math $math, int $id, ClientType $clientType)
    {
        $this->withdrawOperations = [];
        $this->id = $id;
        $this->clientType = $clientType;
        $this->math = $math;
    }

    public function getWithdrawCountByWeek(string $weekIndex): int
    {
        return $this->withdrawOperations[$weekIndex]['count'] ?? 0;
    }

    public function getWithdrawAmountByWeek($weekIndex): string
    {
        return $this->withdrawOperations[$weekIndex]['amount'] ?? '0';
    }

    public function setWithdrawOperationByWeek($weekIndex, string $amount): void
    {
        if (isset($this->withdrawOperations[$weekIndex])) {
            ++$this->withdrawOperations[$weekIndex]['count'];
        } else {;
            $this->withdrawOperations[$weekIndex]['count'] = 1;
        }
        $this->withdrawOperations[$weekIndex]['amount'] = $amount;
    }

    public function addWithdrawOperationByWeek($weekIndex, string $amount): void
    {
        if (isset($this->withdrawOperations[$weekIndex])) {
            $this->withdrawOperations[$weekIndex]['amount'] = $this->math->add(
                $this->withdrawOperations[$weekIndex]['amount'],
                $amount
            );
            ++$this->withdrawOperations[$weekIndex]['count'];
        } else {
            $this->withdrawOperations[$weekIndex]['amount'] = $amount;
            $this->withdrawOperations[$weekIndex]['count'] = 1;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClientType(): ClientType
    {
        return $this->clientType;
    }
}
