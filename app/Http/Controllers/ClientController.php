<?php

namespace App\Http\Controllers;

use App\Application\Commands\Client\CreateClientCommand;
use App\Application\DTOs\ClientDTO;
use App\Domain\Client\Repositories\ClientRepositoryInterface;
use App\Domain\Client\ValueObjects\ClientId;
use App\Http\Requests\CreateClientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function store(CreateClientRequest $request): JsonResponse
    {
        $command = new CreateClientCommand(
            $request->input('name'),
            $request->input('age'),
            $request->input('region'),
            $request->input('income'),
            $request->input('score'),
            $request->input('pin'),
            $request->input('email'),
            $request->input('phone')
        );

        $client = $this->getCommandBus()->dispatch($command);
        $clientDTO = ClientDTO::fromEntity($client);

        return response()->json([
            'id' => $clientDTO->id,
            'name' => $clientDTO->name,
            'message' => 'Client created successfully',
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        Log::info('Showing the user profile for client: {id}', ['id' => $id]);

        $clientRepository = app(ClientRepositoryInterface::class);
        $client = $clientRepository->findById(new ClientId($id));

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $clientDTO = ClientDTO::fromEntity($client);

        return response()->json($clientDTO);
    }
}
