<?php

namespace App\Application\Commands\Loan;

use App\Domain\Client\Repositories\ClientRepositoryInterface;
use App\Domain\CreditCheck\Results\CreditCheckResult;
use App\Domain\CreditCheck\Services\CreditCheckService;
use App\Domain\Loan\Entities\Loan;
use App\Domain\Loan\Repositories\LoanRepositoryInterface;
use DateTime;
use InvalidArgumentException;

class CheckLoanEligibilityHandler
{
    private ClientRepositoryInterface $clientRepository;
    private LoanRepositoryInterface $loanRepository;
    private CreditCheckService $creditCheckService;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        LoanRepositoryInterface $loanRepository,
        CreditCheckService $creditCheckService
    ) {
        $this->clientRepository = $clientRepository;
        $this->loanRepository = $loanRepository;
        $this->creditCheckService = $creditCheckService;
    }

    public function handle(CheckLoanEligibilityCommand $command): CreditCheckResult
    {
        $client = $this->clientRepository->findById($command->clientId);

        if (!$client) {
            throw new InvalidArgumentException('Client not found');
        }

        $loan = new Loan(
            $this->loanRepository->getNextId(),
            $command->loanName,
            $command->amount,
            $command->rate,
            new DateTime($command->startDate),
            new DateTime($command->endDate),
            $client
        );

        // Perform credit check without saving the loan
        return $this->creditCheckService->check($client, $loan);
    }
}
