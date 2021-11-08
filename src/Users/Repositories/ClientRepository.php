<?php

declare(strict_types=1);

namespace Withdrawal\CommissionTask\Users\Repositories;

use DI\Container;
use Withdrawal\CommissionTask\Users\Models\Client;

class ClientRepository
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * since we don't use any kind of database - we will store client object in memory while script is running
     * this will not persist between script calls.
     *
     * @var Client[]
     */
    private array $clients;

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function getClientByIdAndType(int $id, string $clientType): Client
    {
        return $this->clients[$id]
            ?? ($this->clients[$id] = $this->container->make(Client::class, [
                'id' => $id,
                'clientType' => $clientType,
            ]));
    }
}
