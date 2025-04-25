<?php

namespace App\Application\Services;

use App\Domain\Client\Entities\Client;
use App\Domain\Loan\Entities\Loan;

interface NotificationServiceInterface
{
    public function notifyClientAboutLoanApproval(Client $client, Loan $loan): void;
    public function notifyClientAboutLoanRejection(Client $client, Loan $loan, array $reasons): void;
}
