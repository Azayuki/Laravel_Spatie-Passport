<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // 'sometimes' rule makes a field optional
        return [
            'username' => 'sometimes|string|unique:users|max:50',
            'email' => 'sometimes|string|unique:users|max:255',
            'password' => 'sometimes|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // 422 unprocessable content
        $response = response()->json([
            'ok' => false,
            'message' => 'Validation error.',
            'errors' => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);

    }
}