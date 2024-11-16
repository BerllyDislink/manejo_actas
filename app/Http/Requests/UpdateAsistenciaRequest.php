<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateAsistenciaRequest extends FormRequest
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
            'estadoAsistencia' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'estadoAsistencia.required' => 'El campo estado es obligatorio.',
            'estadoAsistencia.string' => 'El campo estado debe ser una cadena de texto.'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,
        response()->json([
            'errors' => $validator->errors(),
            'message' => 'No fue posible actualizar la asistencia'], 422));
    }
}
