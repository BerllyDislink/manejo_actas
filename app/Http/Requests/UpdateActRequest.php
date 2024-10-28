<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActRequest extends FormRequest
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
            'ESTADO' => 'in:aprobada,rechazada,pendiente',
            'SESION_IDSESION' => 'gt:0'
        ];
    }

    public function messages(): array
    {
        return [
            'ESTADO.in' => 'Estado debe ser un valor valido entre (aprobada, rechazada, pendiente)',
            'SESION_IDSESION.gt' => 'El ID_SESION debe ser mayor que 0'
        ];
    }
}
