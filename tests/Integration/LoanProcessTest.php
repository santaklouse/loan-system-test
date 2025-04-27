<?php

namespace Tests\Integration;

use App\Domain\Client\Entities\Client;
use App\Domain\Client\Repositories\ClientRepositoryInterface;
use App\Domain\Client\ValueObjects\ClientId;
use App\Domain\Client\ValueObjects\Region;
use App\Domain\CreditCheck\Services\CreditCheckService;
use App\Domain\Loan\Repositories\LoanRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanProcessTest extends TestCase
{
    use RefreshDatabase;

    private ClientRepositoryInterface $clientRepository;
    private LoanRepositoryInterface $loanRepository;
    private CreditCheckService $creditCheckService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->clientRepository = app(ClientRepositoryInterface::class);
        $this->loanRepository = app(LoanRepositoryInterface::class);
        $this->creditCheckService = app(CreditCheckService::class);
    }

    public function testFullLoanProcess(): void
    {
        // 1. create a client
        $response = $this->postJson('/api/clients', [
            'name' => 'Test Client',
            'age' => 30,
            'region' => 'BR',
            'income' => 1500,
            'score' => 600,
            'pin' => '123-45-6789',
            'email' => 'test@example.com',
            'phone' => '+420123456789',
        ]);

        $response->assertStatus(201);
        $clientId = $response->json('id');

        // 2. check loan eligibility
        $response = $this->postJson('/api/loans/check', [
            // we use In-Memmory repository, so we need to decrement the clientId
            // in order to get the correct clientId
            'client_id' => --$clientId,
            'loan_name' => 'Test Loan',
            'amount' => 1000,
            'rate' => 10,
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
        ]);

        $response->assertStatus(200);
        $eligible = $response->json('eligible');

        if ($eligible) {
            // 3. issue the loan
            $response = $this->postJson('/api/loans/issue', [
                'client_id' => $clientId,
                'loan_name' => 'Test Loan',
                'amount' => 1000,
                'rate' => 10,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
            ]);

            $response->assertStatus(201);
            $this->assertEquals('Test Loan', $response->json('name'));
            $this->assertTrue($response->json('approved'));
        } else {
            // 4. check for errors
            $this->assertNotEmpty($response->json('errors'));
        }
    }

    public function testClientWithLowScoreShouldBeRejected(): void
    {
        // Create a client with a low score
        $client = new Client(
            new ClientId(1),
            'Low Score Client',
            30,
            new Region('BR'),
            1500,
            400, // Score less than 500
            '123-45-6789',
            'test@example.com',
            '+420123456789'
        );

        $this->clientRepository->save($client);

        // Check loan eligibility
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
            ]);

        $errors = $response->json('errors');
        $this->assertNotEmpty($errors);
        $this->assertStringContainsString('score', implode(' ', $errors));
    }
}
