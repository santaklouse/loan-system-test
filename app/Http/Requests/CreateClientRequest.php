<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:120',
            'region' => 'required|string|in:PR,BR,OS',
            'income' => 'required|numeric|min:0',
            'score' => 'required|integer|min:0',
            'pin' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
        ];
    }
}
