<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAsistenciaMiembroRequest extends FormRequest
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
            'listMiembros' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
          'idSesion.required' => 'El id de la sesion no ha sido proporcionado',
          'idSesion.exists' => 'El id de la sesion proporcionada no existe',
          'listMiembros.required' => 'debe proporcionar al menos un miembro',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator,
            response()->json([
                'errors' => $validator->errors(),
                'message' => 'No fue posible establecer las invitaciones (Miembros)'
            ], 422));
    }
}
