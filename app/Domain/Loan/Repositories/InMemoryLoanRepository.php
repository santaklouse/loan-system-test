<?php

namespace App\Domain\Loan\Repositories;

use App\Domain\Client\Repositories\ClientRepositoryInterface;
use App\Domain\Client\ValueObjects\ClientId;
use App\Domain\Loan\Entities\Loan;
use App\Domain\Loan\ValueObjects\LoanId;
use Illuminate\Support\Carbon;

class InMemoryLoanRepository implements LoanRepositoryInterface
{
    private array $loans = [];
    private int $nextId = 1;

    public function __construct()
    {
        $clientRepository = app(ClientRepositoryInterface::class);
        $value = config('loan.sample_loans');

        if (!$value) {
            return;
        }
        $this->loans = array_map(function ($loan, $key) use ($clientRepository) {
            $client = $clientRepository->findById(new ClientId($loan['client_id']));
            if (!$client) {
                throw new \InvalidArgumentException("Client with ID {$loan['client_id']} not found.");
            }
            $loan['id'] = ++$key; // Assuming the keys are 0-indexed
            $this->nextId = ++$key;
            return new Loan(
                id: new LoanId($loan['id']),
                name: $loan['name'],
                amount: $loan['amount'],
                rate: $loan['rate'],
                startDate: new Carbon($loan['start_date']),
                endDate: new Carbon($loan['end_date']),
                client: $client,
                isApproved: $loan['is_approved'] ?? false
            );
        }, $value, array_keys($value));
    }

    public function findById(LoanId $id): ?Loan
    {
        return $this->loans[$id->getValue()] ?? null;
    }

    public function save(Loan $loan): void
    {
        $this->loans[$loan->getId()->getValue()] = $loan;
    }

    public function getNextId(): LoanId
    {
        return new LoanId($this->nextId++);
    }
}
