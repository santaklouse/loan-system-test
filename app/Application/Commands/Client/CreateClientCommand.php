<?php

namespace App\Application\Commands\Client;

class CreateClientCommand
{
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
        string $phone
    ) {
        $this->name = $name;
        $this->age = $age;
        $this->region = $region;
        $this->income = $income;
        $this->score = $score;
        $this->pin = $pin;
        $this->email = $email;
        $this->phone = $phone;
    }
}
