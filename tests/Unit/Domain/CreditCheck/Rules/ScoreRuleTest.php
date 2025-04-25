<?php

namespace Tests\Unit\Domain\CreditCheck\Rules;

use App\Domain\Client\Entities\Client;
use App\Domain\Client\ValueObjects\ClientId;
use App\Domain\Client\ValueObjects\Region;
use App\Domain\CreditCheck\Rules\ScoreRule;
use App\Domain\Loan\Entities\Loan;
use PHPUnit\Framework\TestCase;

class ScoreRuleTest extends TestCase
{
    public function testScoreRuleShouldPassWhenScoreIsGreaterThanMinimum(): void
    {
        $client = new Client(
            new ClientId(1),
            'Test Client',
            30,
            new Region('PR'),
            1500,
            600, // Score greater than 500
            '123-45-6789',
            'test@example.com',
            '+420123456789'
        );

        $loan = $this->createMock(Loan::class);
        $rule = new ScoreRule();

        $result = $rule->check($client, $loan);

        $this->assertTrue($result);
    }

    public function testScoreRuleShouldFailWhenScoreIsBelowMinimum(): void
    {
        $client = new Client(
            new ClientId(1),
            'Test Client',
            30,
            new Region('PR'),
            1500,
            400, // Score less than 500
            '123-45-6789',
            'test@example.com',
            '+420123456789'
        );

        $loan = $this->createMock(Loan::class);
        $rule = new ScoreRule();

        $result = $rule->check($client, $loan);

        $this->assertFalse($result);
    }

    public function testScoreRuleErrorMessage(): void
    {
        $rule = new ScoreRule();

        $errorMessage = $rule->getErrorMessage();

        $this->assertStringContainsString('Credit score is too low', $errorMessage);
    }
}
