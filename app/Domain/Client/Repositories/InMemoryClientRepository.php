<?php

namespace App\Domain\Client\Repositories;

use App\Domain\Client\Entities\Client;
use App\Domain\Client\ValueObjects\ClientId;
use App\Domain\Client\ValueObjects\Region;

class InMemoryClientRepository implements ClientRepositoryInterface
{
    private array $clients = [];
    private int $nextId = 1;

    public function __construct()
    {
        $value = config('loan.sample_clients');

        foreach ($value as $id => $clientData) {
            $this->nextId = ++$id;
            $client = new Client(
                new ClientId($this->nextId++),
                $clientData['name'],
                $clientData['age'],
                new Region($clientData['region']),
                $clientData['income'],
                $clientData['score'],
                $clientData['pin'],
                $clientData['email'],
                $clientData['phone']
            );
            $this->clients[$client->getId()->getValue()] = $client;
        }
    }

    public function findById(ClientId $id): ?Client
    {
        return $this->clients[$id->getValue()] ?? NULL;
    }

    public function save(Client $client): void
    {
        $this->clients[$client->getId()->getValue()] = $client;
    }

    public function getNextId(): ClientId
    {
        return new ClientId($this->nextId++);
    }
}
