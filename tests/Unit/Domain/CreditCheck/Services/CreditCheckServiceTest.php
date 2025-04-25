<?php

namespace Tests\Unit\Domain\CreditCheck\Services;

use App\Domain\Client\Entities\Client;
use App\Domain\CreditCheck\Rules\RuleInterface;
use App\Domain\CreditCheck\Services\CreditCheckService;
use App\Domain\Loan\Entities\Loan;
use PHPUnit\Framework\TestCase;

class CreditCheckServiceTest extends TestCase
{
    public function testCheckShouldReturnApprovedWhenAllRulesPass(): void
    {
        $client = $this->createMock(Client::class);
        $loan = $this->createMock(Loan::class);

        $passingRule = $this->createMock(RuleInterface::class);
        $passingRule->method('check')->willReturn(true);

        $service = new CreditCheckService([$passingRule]);

        $result = $service->check($client, $loan);

        $this->assertTrue($result->isApproved());
        $this->assertEmpty($result->getErrors());
    }

    public function testCheckShouldReturnNotApprovedWithErrorsWhenRulesFail(): void
    {
        // Arrange
        $client = $this->createMock(Client::class);
        $loan = $this->createMock(Loan::class);

        $failingRule = $this->createMock(RuleInterface::class);
        $failingRule->method('check')->willReturn(false);
        $failingRule->method('getErrorMessage')->willReturn('Error message');

        $service = new CreditCheckService([$failingRule]);

        // Act
        $result = $service->check($client, $loan);

        // Assert
        $this->assertFalse($result->isApproved());
        $this->assertCount(1, $result->getErrors());
        $this->assertEquals('Error message', $result->getErrors()[0]);
    }

    public function testCheckShouldCollectAllErrorsWhenMultipleRulesFail(): void
    {
        $client = $this->createMock(Client::class);
        $loan = $this->createMock(Loan::class);

        $failingRule1 = $this->createMock(RuleInterface::class);
        $failingRule1->method('check')->willReturn(false);
        $failingRule1->method('getErrorMessage')->willReturn('Error 1');

        $failingRule2 = $this->createMock(RuleInterface::class);
        $failingRule2->method('check')->willReturn(false);
        $failingRule2->method('getErrorMessage')->willReturn('Error 2');

        $passingRule = $this->createMock(RuleInterface::class);
        $passingRule->method('check')->willReturn(true);

        $service = new CreditCheckService([$failingRule1, $passingRule, $failingRule2]);

        $result = $service->check($client, $loan);

        $this->assertFalse($result->isApproved());
        $this->assertCount(2, $result->getErrors());
        $this->assertEquals(['Error 1', 'Error 2'], $result->getErrors());
    }
}
