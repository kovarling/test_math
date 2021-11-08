<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\DataProviders\Strategies;

use Withdrawal\CommissionTask\DataProviders\Interfaces\DataProviderInterface;

class DirectoryDataProviderStrategy extends AbstractDataProviderStrategy implements DataProviderInterface
{
    private const SUPPORTED_TYPES = ['text\csv', 'text\plain'];

    public function getDataIterable(): \Generator
    {
        $directoryIterator = new \DirectoryIterator(dirname(__DIR__).self::ROOT_FOLDER.$this->getPath());

        foreach ($directoryIterator as $fileInfo) {
            if ($fileInfo->isDot() || in_array(mime_content_type($fileInfo->getPathName()), self::SUPPORTED_TYPES, true)) {
                continue;
            }

            $dataFile = new \SplFileObject($fileInfo->getPathName());
            foreach ($dataFile as $line) {
                yield $line;
            }
        }
    }
}
