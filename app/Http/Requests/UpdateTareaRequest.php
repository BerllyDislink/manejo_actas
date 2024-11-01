<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTareaRequest extends FormRequest
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
            "DESCRIPCION" => "",
            "FECHA_ENTREGA" => "date_format:Y-m-d",
            "SESION_IDSESION" => "exists:sesion,IDSESION",
        ];
    }

    public function messages(): array
    {
        return [
            "FECHA_ENTREGA.date_format" => "La fecha de entrega debe tener el formato yyyy-mm-dd",
            "SESION_IDSESION.exist" => "La sesion seleccionada no existe",
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
