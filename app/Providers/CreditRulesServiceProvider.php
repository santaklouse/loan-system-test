<?php

namespace App\Providers;

use App\Domain\CreditCheck\Rules\AgeRule;
use App\Domain\CreditCheck\Rules\IncomeRule;
use App\Domain\CreditCheck\Rules\OstravaRateRule;
use App\Domain\CreditCheck\Rules\PragueRandomRule;
use App\Domain\CreditCheck\Rules\RegionRule;
use App\Domain\CreditCheck\Rules\ScoreRule;
use App\Domain\CreditCheck\Services\CreditCheckService;
use Illuminate\Support\ServiceProvider;

class CreditRulesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CreditCheckService::class, function () {
            return new CreditCheckService([
                $this->app->make(ScoreRule::class),
                $this->app->make(IncomeRule::class),
                $this->app->make(AgeRule::class),
                $this->app->make(RegionRule::class),
                $this->app->make(PragueRandomRule::class),
                $this->app->make(OstravaRateRule::class),
            ]);
        });
    }
}
