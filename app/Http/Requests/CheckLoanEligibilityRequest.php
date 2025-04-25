<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckLoanEligibilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|integer|min:1',
            'loan_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'rate' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }
}
