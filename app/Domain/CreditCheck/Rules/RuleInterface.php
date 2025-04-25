<?php

namespace App\Domain\CreditCheck\Rules;

use App\Domain\Client\Entities\Client;
use App\Domain\Loan\Entities\Loan;

interface RuleInterface
{
    public function check(Client $client, Loan $loan): bool;
    public function getErrorMessage(): string;
}
