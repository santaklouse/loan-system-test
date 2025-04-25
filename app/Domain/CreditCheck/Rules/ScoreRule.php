<?php

namespace App\Domain\CreditCheck\Rules;

use App\Domain\Client\Entities\Client;
use App\Domain\Loan\Entities\Loan;

class ScoreRule implements RuleInterface
{
    private const MINIMUM_SCORE = 500;

    public function check(Client $client, Loan $loan): bool
    {
        return $client->getScore() > self::MINIMUM_SCORE;
    }

    public function getErrorMessage(): string
    {
        return 'Credit score is too low. Required score: ' . self::MINIMUM_SCORE;
    }
}
