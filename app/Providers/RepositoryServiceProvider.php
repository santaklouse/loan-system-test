<?php

namespace App\Providers;

use App\Domain\Client\Repositories\ClientRepositoryInterface;
use App\Domain\Client\Repositories\InMemoryClientRepository;
use App\Domain\Loan\Repositories\InMemoryLoanRepository;
use App\Domain\Loan\Repositories\LoanRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ClientRepositoryInterface::class, function () {
            return new InMemoryClientRepository();
        });

        $this->app->singleton(LoanRepositoryInterface::class, function () {
            return new InMemoryLoanRepository();
        });
    }
}
