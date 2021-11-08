<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Common\Traits;

use Withdrawal\CommissionTask\Common\Service\Logger;

trait LoggerTrait
{
    protected Logger $logger;

    protected function log(string $string, ?string $filename = null): void
    {
        $this->logger->log($string, $filename);
    }
}
