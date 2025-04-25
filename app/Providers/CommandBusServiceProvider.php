<?php

namespace App\Providers;

use App\Application\CommandBus\CommandBus;
use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CommandBus::class, function ($app) {
            return new CommandBus($app);
        });
    }
}
