<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Common\Service;

class Logger
{
    public const ROOT_FOLDER = '/../../logs/';
    public const DEFAULT_LOG_FILE_NAME = 'runtime.log';

    public function log(string $string, ?string $filename = null): void
    {
        if (is_null($filename)) {
            $filename = self::DEFAULT_LOG_FILE_NAME;
        }

        $time = new \DateTimeImmutable();

        file_put_contents(
            dirname(__DIR__).self::ROOT_FOLDER.$filename,
            $time->format('Y-m-d H:i:s').' -- '.$string.PHP_EOL,
            FILE_APPEND | LOCK_EX
        );
    }
}
