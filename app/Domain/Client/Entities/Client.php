<?php

namespace App\Domain\Client\Entities;

use App\Domain\Client\ValueObjects\ClientId;
use App\Domain\Client\ValueObjects\Region;

class Client
{
    private ClientId $id;
    private string $name;
    private int $age;
    private Region $region;
    private float $income;
    private int $score;
    private string $pin;
    private string $email;
    private string $phone;

    public function __construct(
        ClientId $id,
        string $name,
        int $age,
        Region $region,
        float $income,
        int $score,
        string $pin,
        string $email,
        string $phone
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

    public function getId(): ClientId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getRegion(): Region
    {
        return $this->region;
    }

    public function getIncome(): float
    {
        return $this->income;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getPin(): string
    {
        return $this->pin;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
