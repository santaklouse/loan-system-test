<?php

namespace App\Http\Controllers;

use App\Application\Commands\Loan\CheckLoanEligibilityCommand;
use App\Application\Commands\Loan\IssueLoanCommand;
use App\Application\DTOs\LoanDTO;
use App\Domain\Client\ValueObjects\ClientId;
use App\Domain\Loan\Repositories\LoanRepositoryInterface;
use App\Domain\Loan\ValueObjects\LoanId;
use App\Http\Requests\CheckLoanEligibilityRequest;
use App\Http\Requests\IssueLoanRequest;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    public function check(CheckLoanEligibilityRequest $request): JsonResponse
    {
        $command = new CheckLoanEligibilityCommand(
            new ClientId($request->input('client_id')),
            $request->input('loan_name'),
            $request->input('amount'),
            $request->input('rate'),
            $request->input('start_date'),
            $request->input('end_date')
        );

        $result = $this->getCommandBus()->dispatch($command);

        return response()->json([
            'eligible' => $result->isApproved(),
            'errors' => $result->getErrors(),
        ]);
    }

    public function issue(IssueLoanRequest $request): JsonResponse
    {
        $command = new IssueLoanCommand(
            new ClientId($request->input('client_id')),
            $request->input('loan_name'),
            $request->input('amount'),
            $request->input('rate'),
            $request->input('start_date'),
            $request->input('end_date')
        );

        $result = $this->getCommandBus()->dispatch($command);
        $loan = $result->getLoan();
        $errors = $result->getErrors();
        $loanDTO = LoanDTO::fromEntity($loan);

        $response = [
            'id' => $loanDTO->id,
            'name' => $loanDTO->name,
            'approved' => $loanDTO->isApproved,
            'client_id' => $loanDTO->clientId,
            'message' => 'Loan processed successfully',
        ];

        if ($response['approved'] === FALSE) {
            $response['errors'] = $errors;
        }

        return response()->json($response, 201);
    }

    public function show(int $id): JsonResponse
    {
        $loanRepository = app(LoanRepositoryInterface::class);
        $loan = $loanRepository->findById(new LoanId($id));

        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }

        $loanDTO = LoanDTO::fromEntity($loan);

        return response()->json($loanDTO);
    }
}
