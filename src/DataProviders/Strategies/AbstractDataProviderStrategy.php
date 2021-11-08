<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\DataProviders\Strategies;

class AbstractDataProviderStrategy
{
    public const ROOT_FOLDER = '/../../';

    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
