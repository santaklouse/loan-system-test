<?php

namespace App\Domain\CreditCheck\Rules;

use App\Domain\Client\Entities\Client;
use App\Domain\Loan\Entities\Loan;

class AgeRule implements RuleInterface
{
    private const MIN_AGE = 18;
    private const MAX_AGE = 60;

    public function check(Client $client, Loan $loan): bool
    {
        $age = $client->getAge();
        return $age >= self::MIN_AGE && $age <= self::MAX_AGE;
    }

    public function getErrorMessage(): string
    {
        return 'Client age must be between ' . self::MIN_AGE . ' and ' . self::MAX_AGE . ' years';
    }
}
