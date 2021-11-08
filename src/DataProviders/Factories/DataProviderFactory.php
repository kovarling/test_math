<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\DataProviders\Factories;

use DI\Container;
use DI\NotFoundException;
use Withdrawal\CommissionTask\Common\Service\Logger;
use Withdrawal\CommissionTask\Common\Traits\LoggerTrait;
use Withdrawal\CommissionTask\DataProviders\Interfaces\DataProviderInterface;
use Withdrawal\CommissionTask\DataProviders\Strategies\DirectoryDataProviderStrategy;
use Withdrawal\CommissionTask\DataProviders\Strategies\FileDataProviderStrategy;

class DataProviderFactory
{
    use LoggerTrait;

    private const ROOT_FOLDER = '/../../';
    private Container $container;

    public function __construct(Container $container, Logger $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function getDataProviderForPath(string $path): DataProviderInterface
    {
        $absPath = dirname(__DIR__).self::ROOT_FOLDER.$path;

        if (is_dir($absPath)) {
            $this->log("scanned path - $path is directory");

            return $this->container->make(DirectoryDataProviderStrategy::class, ['path' => $path]);
        } elseif (is_file($absPath)) {
            $this->log("scanned path - $path is file");

            return $this->container->make(FileDataProviderStrategy::class, ['path' => $path]);
        }

        throw new NotFoundException("Path provided `$absPath` is neither folder nor file");
    }
}
