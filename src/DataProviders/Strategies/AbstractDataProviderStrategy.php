<?php

namespace Withdrawal\CommissionTask\DataProviders\Strategies;

class AbstractDataProviderStrategy
{
    public const ROOT_FOLDER = '/../../';

    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}