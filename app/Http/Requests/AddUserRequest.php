<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // set return to true to even access this request
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
        // 'column' => 'rules'
        // where 'rules'
        // 'required|string|unique:users|max:25'
        return [
            'username' => 'required|string|unique:users|max:50',
            'email' => 'required|string|unique:users|max:255',
            'password' => 'required|string',
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