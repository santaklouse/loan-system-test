<?php

namespace App\Application\DTOs;

use App\Domain\Loan\Entities\Loan;

class LoanDTO
{
    public ?int $id;
    public string $name;
    public float $amount;
    public float $rate;
    public string $startDate;
    public string $endDate;
    public int $clientId;
    public bool $isApproved;

    public function __construct(
        string $name,
        float $amount,
        float $rate,
        string $startDate,
        string $endDate,
        int $clientId,
        bool $isApproved = false,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->amount = $amount;
        $this->rate = $rate;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->clientId = $clientId;
        $this->isApproved = $isApproved;
    }

    public static function fromEntity(Loan $loan): self
    {
        return new self(
            $loan->getName(),
            $loan->getAmount(),
            $loan->getRate(),
            $loan->getStartDate()->format('Y-m-d'),
            $loan->getEndDate()->format('Y-m-d'),
            $loan->getClient()->getId()->getValue(),
            $loan->isApproved(),
            $loan->getId()->getValue()
        );
    }
}
