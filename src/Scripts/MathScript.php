<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Scripts;

use Withdrawal\CommissionTask\Common\Service\ExceptionFormatter;
use Withdrawal\CommissionTask\Common\Service\Logger;
use Withdrawal\CommissionTask\Common\Traits\LoggerTrait;
use Withdrawal\CommissionTask\Currencies\Exceptions\RatesException;
use Withdrawal\CommissionTask\DataProviders\Factories\DataProviderFactory;
use Withdrawal\CommissionTask\Operations\Factories\OperationFactory;
use Withdrawal\CommissionTask\Operations\Strategies\OperationStrategyFactory;
use Withdrawal\CommissionTask\Users\Enums\ClientType;
use Withdrawal\CommissionTask\Users\Repositories\ClientRepository;

class MathScript
{
    use LoggerTrait;

    // indexes as constants to have 1 place to modify them if needed
    public const DATA_DATE = 0;
    public const DATA_CLIENT_ID = 1;
    public const DATA_CLIENT_TYPE = 2;
    public const DATA_OPERATION_TYPE = 3;
    public const DATA_AMOUNT = 4;
    public const DATA_CURRENCY = 5;

    public const DATA_EXPECTED_COLUMNS_COUNT = 6;

    private ClientRepository $clientRepository;
    private OperationStrategyFactory $operationStrategyFactory;
    private DataProviderFactory $dataProviderFactory;
    private ExceptionFormatter $exceptionFormatter;

    private string $path;

    public function __construct(
        ClientRepository $clientRepository,
        OperationStrategyFactory $operationStrategyFactory,
        DataProviderFactory $dataProviderFactory,
        Logger $logger,
        ExceptionFormatter $exceptionFormatter,
        string $path
    ) {
        $this->clientRepository = $clientRepository;
        $this->operationStrategyFactory = $operationStrategyFactory;
        $this->dataProviderFactory = $dataProviderFactory;
        $this->path = $path;
        $this->logger = $logger;
        $this->exceptionFormatter = $exceptionFormatter;
    }

    public function output(): void
    {
        try {
            foreach ($this->perform() as $line) {
                echo "$line\n";
            }
        } catch (\Exception $e) {
            echo $this->exceptionFormatter->format($e);
        }
        exit;
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \JsonException
     * @throws \Exception
     * @throws RatesException
     */
    public function perform(): \Iterator
    {
        $this->log('Math Script started');
        $dataProvider = $this->dataProviderFactory->getDataProviderForPath($this->path);
        foreach ($dataProvider->getDataIterable() as $line) {
            yield $this->processLine($line);
        }
        $this->log('Math Script ended');
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     * @throws \JsonException
     * @throws RatesException
     */
    private function processLine($line): string
    {
        $data = explode(',', $line);

        if (!$this->isDataValid($data)) {
            throw new \Exception('Invalid data provided');
        }

        $client = $this->clientRepository->getClientByIdAndType(
            (int) $data[self::DATA_CLIENT_ID],
            ClientType::from($data[self::DATA_CLIENT_TYPE])
        );

        $operation = OperationFactory::create(
            $data[self::DATA_DATE],
            $data[self::DATA_OPERATION_TYPE],
            $data[self::DATA_AMOUNT],
            $data[self::DATA_CURRENCY],
            $client
        );

        $strategy = $this->operationStrategyFactory->getOperationStrategy($operation);

        // TODO: change decimals per currency
        return number_format($strategy->calculateFee(), $operation->getDecimalsCount(), '.', '');
    }

    private function isDataValid(array $data): bool
    {
        $isValid = true;

        if (count($data) !== self::DATA_EXPECTED_COLUMNS_COUNT) {
            $isValid = false;
        }

        return $isValid;
    }
}
