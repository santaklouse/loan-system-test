<?php

namespace App\Domain\CreditCheck\Results;

use App\Domain\Loan\Entities\Loan;

class CreditCheckResult
{
    private bool $isApproved;
    private array $errors;
    private Loan $loan;

    public function __construct(Loan $loan, bool $isApproved, array $errors = [])
    {
        $this->loan = $loan;
        $this->isApproved = $isApproved;
        $this->errors = $errors;
    }

    public function isApproved(): bool
    {
        return $this->isApproved;
    }

    public function getLoan(): Loan
    {
        return $this->loan;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
