<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Nette\Schema\ValidationException;

class CreateUserCredential extends FormRequest
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
            "nombre" => "required",
            "cargo" => "required",
            "rol" => "required|in:coordinador,secretario,miembro,invitado,estudiante",
            "dependencia" => "",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed",
        ];
    }

    public function messages(): array
    {
        return [
            "nombre.required" => "El campo nombre es obligatorio",
            "cargo.required" => "El campo cargo es obligatorio",
            "rol.required" => "El campo rol es obligatorio",
            "rol.in" => "El campo rol debe ser un rol valido",
            "email.required" => "El campo email es obligatorio",
            "email.email" => "El campo email no es valido",
            "email.unique" => "El email ya existe",
            "password.required" => "El campo password es obligatorio",
            "password.confirmed" => "El campo confirm password no coincide",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator,
            response()->json([
                'errors' => $validator->errors(),
                'message' => 'Error de validación'
            ], 422));
    }
}
