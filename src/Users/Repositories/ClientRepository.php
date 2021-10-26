<?php

declare(strict_types=1);


namespace Withdrawal\CommissionTask\Users\Repositories;


use Withdrawal\CommissionTask\Users\Models\Client;
use Withdrawal\CommissionTask\Users\Enums\ClientType;
use DI\Container as Container;

class ClientRepository
{

    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * since we don't use any kind of database - we will store client object in memory while script is running
     * this will not persist between script calls
     * @var Client[]
     */
    private array $clients;

    public function getClientByIdAndType(int $id, ClientType $clientType) : Client
    {
        return $this->clients[$id]
            ?? ($this->clients[$id] = $this->container->make(Client::class, [
                'id' => $id,
                'clientType' => $clientType
            ]));
    }

}