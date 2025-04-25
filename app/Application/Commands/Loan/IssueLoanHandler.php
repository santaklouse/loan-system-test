<?php

namespace App\Application\Commands\Loan;

use App\Application\Services\NotificationServiceInterface;
use App\Domain\Client\Repositories\ClientRepositoryInterface;
use App\Domain\CreditCheck\Results\CreditCheckResult;
use App\Domain\CreditCheck\Services\CreditCheckService;
use App\Domain\Loan\Entities\Loan;
use App\Domain\Loan\Repositories\LoanRepositoryInterface;
use DateTime;
use InvalidArgumentException;

class IssueLoanHandler
{
    private ClientRepositoryInterface $clientRepository;
    private LoanRepositoryInterface $loanRepository;
    private CreditCheckService $creditCheckService;
    private NotificationServiceInterface $notificationService;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        LoanRepositoryInterface $loanRepository,
        CreditCheckService $creditCheckService,
        NotificationServiceInterface $notificationService
    ) {
        $this->clientRepository = $clientRepository;
        $this->loanRepository = $loanRepository;
        $this->creditCheckService = $creditCheckService;
        $this->notificationService = $notificationService;
    }

    public function handle(IssueLoanCommand $command): CreditCheckResult
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

        $checkResult = $this->creditCheckService->check($client, $loan);

        if ($checkResult->isApproved()) {
            $loan->approve();
            $this->loanRepository->save($loan);
            $this->notificationService->notifyClientAboutLoanApproval($client, $loan);
        } else {
            $loan->reject();
            $this->notificationService->notifyClientAboutLoanRejection($client, $loan, $checkResult->getErrors());
        }

        return $checkResult;
    }
}
