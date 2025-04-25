<?php

namespace App\Http\Controllers;

use App\Application\CommandBus\CommandBus;

abstract class Controller
{
    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Get the command bus instance.
     *
     * @return CommandBus
     */
    public function getCommandBus(): CommandBus
    {
        return $this->commandBus;
    }

}
