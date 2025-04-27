<?php

namespace Tests\Feature\Http\Controllers;

use App\Application\Commands\Loan\CheckLoanEligibilityHandler;
use App\Application\Commands\Loan\IssueLoanHandler;
use App\Domain\Client\Entities\Client;
use App\Domain\Client\Repositories\ClientRepositoryInterface;
use App\Domain\Client\ValueObjects\ClientId;
use App\Domain\Client\ValueObjects\Region;
use App\Domain\CreditCheck\Results\CreditCheckResult;
use App\Domain\Loan\Entities\Loan;
use App\Domain\Loan\ValueObjects\LoanId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanControllerTest extends TestCase
{
    use RefreshDatabase;

    private ClientId $clientId;
    private Client $client;
    private Loan $loan;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->clientId = new ClientId(1);

        $this->client = new Client(
            $this->clientId,
            'Test Client',
            30,
            new Region('PR'),
            1500,
            600,
            '123-45-6789',
            'test@example.com',
            '+420123456789'
        );

        $this->loan = new Loan(
            new LoanId(1),
            'Test Loan',
            1000,
            10,
            new \DateTime('2024-01-01'),
            new \DateTime('2024-12-31'),
            $this->client,
            true
        );

        parent::__construct($name);
    }

    public function testCheckLoanEligibilityReturnsCorrectResponse(): void
    {
        $mockHandler = $this->createMock(CheckLoanEligibilityHandler::class);
        $mockHandler->method('handle')->willReturn(new CreditCheckResult($this->loan, true));

        $this->app->instance(CheckLoanEligibilityHandler::class, $mockHandler);

        $response = $this->postJson('/api/loans/check', [
            'client_id' => 1,
            'loan_name' => 'Test Loan',
            'amount' => 1000,
            'rate' => 10,
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'eligible' => true,
                'errors' => [],
            ]);
    }

    public function testIssueLoanReturnsCorrectResponse(): void
    {
        $mockClientRepository = $this->createMock(ClientRepositoryInterface::class);
        $mockClientRepository->method('findById')->willReturn($this->client);

        $mockHandler = $this->createMock(IssueLoanHandler::class);
        $mockHandler->method('handle')->willReturn(new CreditCheckResult($this->loan, true));

        $this->app->instance(ClientRepositoryInterface::class, $mockClientRepository);
        $this->app->instance(IssueLoanHandler::class, $mockHandler);

        $response = $this->postJson('/api/loans/issue', [
            'client_id' => 1,
            'loan_name' => 'Test Loan',
            'amount' => 1000,
            'rate' => 10,
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'id' => 1,
                'name' => 'Test Loan',
                'approved' => true,
                'message' => 'Loan processed successfully',
                'client_id' => 1,
            ]);
    }

    public function testCheckLoanEligibilityReturnsNotEligible(): void
    {
        $mockHandler = $this->createMock(CheckLoanEligibilityHandler::class);
        $mockHandler->method('handle')->willReturn(new CreditCheckResult($this->loan, false, ['Not eligible']));

        $this->app->instance(CheckLoanEligibilityHandler::class, $mockHandler);

        $response = $this->postJson('/api/loans/check', [
            'client_id' => 1,
            'loan_name' => 'Test Loan',
            'amount' => 1000,
            'rate' => 10,
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'eligible' => false,
                'errors' => ['Not eligible'],
            ]);
    }

}
