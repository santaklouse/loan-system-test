<?php

namespace Tests\Unit\Domain\Client;

use App\Application\Commands\Client\CreateClientCommand;
use App\Application\Commands\Client\CreateClientHandler;
use App\Domain\Client\Entities\Client;
use App\Domain\Client\Repositories\ClientRepositoryInterface;
use App\Domain\Client\ValueObjects\ClientId;
use PHPUnit\Framework\TestCase;

class CreateClientHandlerTest extends TestCase
{
    public function testHandleShouldCreateAndSaveClient(): void
    {
        $clientId = new ClientId(1);

        $clientRepository = $this->createMock(ClientRepositoryInterface::class);
        $clientRepository->method('getNextId')->willReturn($clientId);
        $clientRepository->expects($this->once())->method('save');

        $handler = new CreateClientHandler($clientRepository);

        $command = new CreateClientCommand(
            'Test Client',
            30,
            'PR',
            1500,
            600,
            '123-45-6789',
            'test@example.com',
            '+420123456789'
        );

        $client = $handler->handle($command);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals('Test Client', $client->getName());
        $this->assertEquals(30, $client->getAge());
        $this->assertEquals('PR', $client->getRegion()->getCode());
        $this->assertEquals(1500, $client->getIncome());
        $this->assertEquals(600, $client->getScore());
        $this->assertEquals('123-45-6789', $client->getPin());
        $this->assertEquals('test@example.com', $client->getEmail());
        $this->assertEquals('+420123456789', $client->getPhone());
    }
}
