<?php

declare(strict_types=1);


namespace Withdrawal\CommissionTask\Scripts;


use Withdrawal\CommissionTask\Operations\Factories\OperationFactory;
use Withdrawal\CommissionTask\Operations\Strategies\OperationStrategyFactory;
use Withdrawal\CommissionTask\Service\Math;
use DirectoryIterator;
use Withdrawal\CommissionTask\Users\Enums\ClientType;
use Withdrawal\CommissionTask\Users\Repositories\ClientRepository;

class MathScript
{
    const INPUT_PATH = '/../../input';

    // indexes as constants to have 1 place to modify them if needed
    const DATA_DATE = 0;
    const DATA_CLIENT_ID = 1;
    const DATA_CLIENT_TYPE = 2;
    const DATA_OPERATION_TYPE = 3;
    const DATA_AMOUNT = 4;
    const DATA_CURRENCY = 5;

    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public function perform() {

        foreach (new DirectoryIterator(dirname(__FILE__).self::INPUT_PATH) as $fileInfo) {
            if($fileInfo->isDot()) continue;

            $dataFile = new \SplFileObject($fileInfo->getPathName());
            foreach ($dataFile as $line) {
                echo self::processLine($line)."\n";
            }

        }

    }

    /**
     * @param $line
     * @return string
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    private function processLine($line) : string
    {
        $data = explode(',', $line);

        if (!self::isDataValid($data)) {
            throw new \Exception('Invalid data provided');
        }

        $client = $this->clientRepository->getClientByIdAndType(
            (int)$data[self::DATA_CLIENT_ID],
            ClientType::from($data[self::DATA_CLIENT_TYPE])
        );

        $operation = OperationFactory::create(
            $data[self::DATA_DATE],
            $data[self::DATA_OPERATION_TYPE],
            $data[self::DATA_AMOUNT],
            $data[self::DATA_CURRENCY],
            $client
        );

        $strategy = OperationStrategyFactory::getOperationStrategy($operation);

        // TODO: change decimals per currency
        return number_format($strategy->calculateFee(), $operation->getDecimalsCount(),'.','');
    }

    private function isDataValid(array $data) : bool
    {
        $isValid = true;

        if(count($data) !== 6){
            $isValid = false;
        }

        return $isValid;
    }
}