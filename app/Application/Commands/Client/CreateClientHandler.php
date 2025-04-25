<?php

namespace App\Application\Commands\Client;

use App\Domain\Client\Entities\Client;
use App\Domain\Client\Repositories\ClientRepositoryInterface;
use App\Domain\Client\ValueObjects\Region;

class CreateClientHandler
{
    private ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function handle(CreateClientCommand $command): Client
    {
        $clientId = $this->clientRepository->getNextId();

        $client = new Client(
            $clientId,
            $command->name,
            $command->age,
            new Region($command->region),
            $command->income,
            $command->score,
            $command->pin,
            $command->email,
            $command->phone
        );

        $this->clientRepository->save($client);

        return $client;
    }
}
