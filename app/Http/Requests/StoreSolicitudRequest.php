<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSolicitudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'asunto'            =>  'required|string',
            'desicion'          =>  'required|string',
            'fecha_solicitud'   =>  'required|date',
            'dependencia'       =>  'required|string',
            'sesion_id'         =>  'required|integer|exists:sesion,idsesion',
            'descripcion_id'    =>  'required|integer|exists:descripcion,id_descripcion',
            'solicitante_id'    =>  'required|integer|exists:solicitantes,id_solicitante',
        ];
    }
}
