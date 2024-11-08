<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Validation\ValidationException;

class CreateAsistenciaInvitadoRequest extends FormRequest
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
            'idSesion' => 'required|exists:sesion,IDSESION',
            'listInvitados' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'idSesion.required' => 'El id de la sesion no ha sido proporcionado',
            'idSesion.exists' => 'El id de la sesion proporcinada no existe',
            'listInvitados.required' => 'debe proporcionar al menos un invitado',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw  new ValidationException($validator,
            response()->json(['errors' => $validator->errors(),
                'message' => 'No fue posible establecer las invitaciones (Invitados)'], 422));
    }
}
