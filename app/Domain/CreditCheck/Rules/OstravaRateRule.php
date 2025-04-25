<?php

namespace App\Domain\CreditCheck\Rules;

use App\Domain\Client\Entities\Client;
use App\Domain\Loan\Entities\Loan;

class OstravaRateRule implements RuleInterface
{
    private const RATE_INCREASE = 5; // Increase rate by 5%

    public function check(Client $client, Loan $loan): bool
    {
        // Check if the client is from Ostrava
        if ($client->getRegion()->isOstrava()) {
            $newRate = $loan->getRate() + self::RATE_INCREASE;
            $loan->setRate($newRate);
        }

        // Check if the new rate is within acceptable limits
        return true;
    }

    public function getErrorMessage(): string
    {
        return ''; // No error message needed for this rule
    }

    public function isApplicable(Client $client, Loan $loan): bool
    {
        // Check if the client is from Ostrava
        return $client->getRegion()->isOstrava();
    }

    public function getName(): string
    {
        return 'OstravaRateRule';
    }
}
