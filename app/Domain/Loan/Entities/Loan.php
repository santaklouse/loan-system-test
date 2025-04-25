<?php

namespace App\Domain\Loan\Entities;

use App\Domain\Client\Entities\Client;
use App\Domain\Loan\ValueObjects\LoanId;
use DateTimeInterface;

class Loan
{
    private LoanId $id;
    private string $name;
    private float $amount;
    private float $rate;
    private DateTimeInterface $startDate;
    private DateTimeInterface $endDate;
    private Client $client;
    private bool $isApproved;

    public function __construct(
        LoanId $id,
        string $name,
        float $amount,
        float $rate,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate,
        Client $client,
        bool $isApproved = false
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->amount = $amount;
        $this->rate = $rate;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->client = $client;
        $this->isApproved = $isApproved;
    }

    public function getId(): LoanId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    public function getStartDate(): DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTimeInterface
    {
        return $this->endDate;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function isApproved(): bool
    {
        return $this->isApproved;
    }

    public function approve(): void
    {
        $this->isApproved = true;
    }

    public function reject(): void
    {
        $this->isApproved = false;
    }
}
