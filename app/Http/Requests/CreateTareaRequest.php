<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTareaRequest extends FormRequest
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
            "DESCRIPCION" => "required",
            "FECHA_ENTREGA" => "required|date_format:Y-m-d",
            "SESION_IDSESION" => "required|exists:sesion,IDSESION",
        ];
    }

    public function messages(): array
    {
        return [
            "DESCRIPCION.required" => "Debes proporcionar una descripcion para la tarea",
            "FECHA_ENTREGA.date_format" => "La fecha de entrega debe tener el formato yyyy-mm-dd",
            "FECHA_ENTREGA.required" => "Debes proporcionar una fecha de entrega para la tarea",
            "SESION_IDSESION.required" => "Debes seleccionar una sesion para la tarea",
            "SESION_IDSESION.exists" => "La sesion seleccionada no existe",
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator,
            response()->json([
                'errors' => $validator->errors(),
                'message' => 'Error de validación'
            ], 422));
    }
}
