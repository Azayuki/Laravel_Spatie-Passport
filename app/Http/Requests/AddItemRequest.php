<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddItemRequest extends FormRequest
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
        return [
            'code' => 'required|alpha_dash|unique:items|max:32',
            'name' => 'required|string|max:128',
            'price' => 'required|numeric|min:0',
            'item_type' => 'required|string|max:64',
            'supplier' => 'required|string|max:128',
            'currency' => 'required|string|size:3',
            'image_url' => 'sometimes|url|max:256',
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