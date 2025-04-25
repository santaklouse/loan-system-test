<?php

namespace App\Domain\CreditCheck\Services;

use App\Domain\Client\Entities\Client;
use App\Domain\CreditCheck\Results\CreditCheckResult;
use App\Domain\CreditCheck\Rules\RuleInterface;
use App\Domain\Loan\Entities\Loan;

class CreditCheckService
{
    /**
     * @var RuleInterface[]
     */
    private array $rules;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function check(Client $client, Loan $loan): CreditCheckResult
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            if (!$rule->check($client, $loan)) {
                $errors[] = $rule->getErrorMessage();
            }
        }

        return new CreditCheckResult($loan, empty($errors), $errors);
    }
}
