<?php

namespace Withdrawal\CommissionTask\DataProviders\Strategies;

use Withdrawal\CommissionTask\DataProviders\Interfaces\DataProviderInterface;

class FileDataProviderStrategy extends AbstractDataProviderStrategy implements DataProviderInterface
{
    public function getDataIterable(): \Generator
    {
        $dataFile = new \SplFileObject(dirname(__DIR__).self::ROOT_FOLDER.$this->getPath());
        foreach ($dataFile as $line) {
            yield $line;
        }
    }
}