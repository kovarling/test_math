<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\DataProviders\Factories;

use DI\Container;
use DI\NotFoundException;
use Withdrawal\CommissionTask\DataProviders\Interfaces\DataProviderInterface;
use Withdrawal\CommissionTask\DataProviders\Strategies\DirectoryDataProviderStrategy;
use Withdrawal\CommissionTask\DataProviders\Strategies\FileDataProviderStrategy;

class DataProviderFactory
{
    private const ROOT_FOLDER = '/../../';
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function getDataProviderForPath(string $path): DataProviderInterface
    {
        $absPath = dirname(__DIR__).self::ROOT_FOLDER.$path;
        if (is_dir($absPath)) {
            return $this->container->make(DirectoryDataProviderStrategy::class, ['path' => $path]);
        } elseif (is_file($absPath)) {
            return $this->container->make(FileDataProviderStrategy::class, ['path' => $path]);
        }

        throw new NotFoundException("Path provided `$absPath` is neither folder nor file");
    }
}
