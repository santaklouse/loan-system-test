<?php

namespace App\Domain\CreditCheck\Rules;

use App\Domain\Client\Entities\Client;
use App\Domain\Loan\Entities\Loan;

class PragueRandomRule implements RuleInterface
{
    private const REJECTION_PROBABILITY = 0.3; // 30% chance of rejection

    public function check(Client $client, Loan $loan): bool
    {
        // Check if the client is from Prague
        if (!$client->getRegion()->isPrague()) {
            return true;
        }

        // Random rejection for clients from Prague
        return mt_rand(1, 100) > (self::REJECTION_PROBABILITY * 100);
    }

    public function isApplicable(Client $client, Loan $loan): bool
    {
        // Check if the client is from Prague
        return $client->getRegion()->isPrague();
    }

    public function getErrorMessage(): string
    {
        return 'Random rejection for clients from Prague';
    }
}
