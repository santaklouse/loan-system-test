<?php

namespace App\Domain\CreditCheck\Rules;

use App\Domain\Client\Entities\Client;
use App\Domain\Loan\Entities\Loan;

class IncomeRule implements RuleInterface
{
    private const MINIMUM_INCOME = 1000;

    public function check(Client $client, Loan $loan): bool
    {
        return $client->getIncome() >= self::MINIMUM_INCOME;
    }

    public function getErrorMessage(): string
    {
        return 'Income is too low. Required income: $' . self::MINIMUM_INCOME;
    }
}
