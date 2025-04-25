<?php

namespace App\Application\Commands\Loan;

use App\Domain\Client\ValueObjects\ClientId;

class IssueLoanCommand
{
    public ClientId $clientId;
    public string $loanName;
    public float $amount;
    public float $rate;
    public string $startDate;
    public string $endDate;

    public function __construct(
        ClientId $clientId,
        string $loanName,
        float $amount,
        float $rate,
        string $startDate,
        string $endDate
    ) {
        $this->clientId = $clientId;
        $this->loanName = $loanName;
        $this->amount = $amount;
        $this->rate = $rate;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}
