<?php

namespace App\Application\DTOs;

use App\Domain\Client\Entities\Client;

class ClientDTO
{
    public ?int $id;
    public string $name;
    public int $age;
    public string $region;
    public float $income;
    public int $score;
    public string $pin;
    public string $email;
    public string $phone;

    public function __construct(
        string $name,
        int $age,
        string $region,
        float $income,
        int $score,
        string $pin,
        string $email,
        string $phone,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->region = $region;
        $this->income = $income;
        $this->score = $score;
        $this->pin = $pin;
        $this->email = $email;
        $this->phone = $phone;
    }

    public static function fromEntity(Client $client): self
    {
        return new self(
            $client->getName(),
            $client->getAge(),
            $client->getRegion()->getCode(),
            $client->getIncome(),
            $client->getScore(),
            $client->getPin(),
            $client->getEmail(),
            $client->getPhone(),
            $client->getId()->getValue()
        );
    }
}
