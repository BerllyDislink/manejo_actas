<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email",
            "password" => "required"
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "El email es obligatorio",
            "email.email" => "El email debe ser un email",
            "password.required" => "El password es obligatorio"
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator,
            response()->json([
                'errors' => $validator->errors(),
                'message' => 'Verifique la informacion ingresada'
            ], 422));
    }
}
