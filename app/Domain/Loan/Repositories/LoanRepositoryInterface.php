<?php

namespace App\Domain\Loan\Repositories;

use App\Domain\Loan\Entities\Loan;
use App\Domain\Loan\ValueObjects\LoanId;

interface LoanRepositoryInterface
{
    public function findById(LoanId $id): ?Loan;
    public function save(Loan $loan): void;
    public function getNextId(): LoanId;
}
