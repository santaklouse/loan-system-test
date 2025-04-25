<?php

namespace App\Application\Services;

use App\Domain\Client\Entities\Client;
use App\Domain\Loan\Entities\Loan;
use Illuminate\Support\Facades\Log;

class LogNotificationService implements NotificationServiceInterface
{
    public function notifyClientAboutLoanApproval(Client $client, Loan $loan): void
    {
        $message = sprintf(
            '[%s] Уведомление клиенту [%s]: Кредит "%s" одобрен.',
            now()->format('Y-m-d H:i:s'),
            $client->getName(),
            $loan->getName()
        );

        Log::info($message);
    }

    public function notifyClientAboutLoanRejection(Client $client, Loan $loan, array $reasons): void
    {
        $message = sprintf(
            '[%s] Уведомление клиенту [%s]: Кредит "%s" отклонен. Причины: %s',
            now()->format('Y-m-d H:i:s'),
            $client->getName(),
            $loan->getName(),
            implode('; ', $reasons)
        );

        Log::info($message);
    }
}
