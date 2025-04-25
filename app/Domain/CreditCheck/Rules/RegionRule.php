<?php

namespace App\Domain\CreditCheck\Rules;

use App\Domain\Client\Entities\Client;
use App\Domain\Client\ValueObjects\Region;
use App\Domain\Loan\Entities\Loan;

class RegionRule implements RuleInterface
{
    private const ALLOWED_REGIONS = [
        Region::PRAGUE,
        Region::BRNO,
        Region::OSTRAVA,
    ];

    public function check(Client $client, Loan $loan): bool
    {
        return in_array($client->getRegion()->getCode(), self::ALLOWED_REGIONS);
    }

    public function getErrorMessage(): string
    {
        return 'Client region is not eligible for loan. Allowed regions: Prague (PR), Brno (BR), Ostrava (OS)';
    }
}
