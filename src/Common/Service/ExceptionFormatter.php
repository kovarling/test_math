<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Common\Service;

use Withdrawal\CommissionTask\Common\Traits\LoggerTrait;

class ExceptionFormatter
{
    use LoggerTrait;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function format(\Exception $e): string
    {
        $exceptionType = (new \ReflectionClass($e))->getShortName();

        $exceptionString = "Exception of type $exceptionType was thrown with details below:\n"
            .'- Exception code '.$e->getCode()."\n"
            .'- In file '.$e->getFile()."\n"
            .'- On line '.$e->getLine()."\n"
            .'- With message "'.$e->getMessage()."\n";

        $this->log($exceptionString);

        return $exceptionString;
    }
}
