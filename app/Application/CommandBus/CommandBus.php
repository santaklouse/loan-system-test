<?php

namespace App\Application\CommandBus;

use Psr\Container\ContainerInterface;
use ReflectionClass;

class CommandBus
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function dispatch(object $command): mixed
    {
        $handlerClass = $this->resolveHandlerClass($command);

        $handler = $this->container->get($handlerClass);

        return $handler->handle($command);
    }

    private function resolveHandlerClass(object $command): string
    {
        $reflection = new ReflectionClass($command::class);
        $commandName = $reflection->getShortName();

        // Naming: {CommandName}Command -> {CommandName}Handler
        $handlerClassName = str_replace('Command', 'Handler', $commandName);
        $handlerNamespace = str_replace('Commands', 'Commands', $reflection->getNamespaceName());

        return $handlerNamespace . '\\' . $handlerClassName;
    }
}
