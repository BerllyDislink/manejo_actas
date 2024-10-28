<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateActaRequest extends FormRequest
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
            'ESTADO' => 'required|in:aprobada,rechazada,pendiente',
            'SESION_IDSESION' => 'required|exists:sesion,IDSESION',
        ];
    }

    public function messages(): array
    {
        return [
            'ESTADO.required' => 'Estado es requerido',
            'ESTADO.in' => 'Estado debe ser un valor valido entre (aprobada, rechazada, pendiente)',
            'SESION_IDSESION.required' => 'el id de la sesion es requerido',
            'SESION_IDSESION.exists' => 'El id de la sesion no existe',
        ];
    }
}
