<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreDescripcionRequest extends FormRequest
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
            'numero_estudiantes'    => 'required|integer',
            'estudiantes'           => 'required|string',
            'numero_docentes'       => 'required|integer',
            'docentes'              => 'required|string',
            'ciudad'                => 'required|string',
            'pais'                  => 'required|string',
            'evento'                => 'required|string',
        ];
    }
}
