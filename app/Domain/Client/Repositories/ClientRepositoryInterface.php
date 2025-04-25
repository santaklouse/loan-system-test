<?php

namespace App\Domain\Client\Repositories;

use App\Domain\Client\Entities\Client;
use App\Domain\Client\ValueObjects\ClientId;

interface ClientRepositoryInterface
{
    public function findById(ClientId $id): ?Client;
    public function save(Client $client): void;
    public function getNextId(): ClientId;
}
