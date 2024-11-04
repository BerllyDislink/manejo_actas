<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitanteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->ID_SOLICITANTE,
            'nombre'            => $this->NOMBRE,
            'tipo_solicitante'  => $this->TIPO_DE_SOLICITANTE,
            'email'             => $this->EMAIL,
            'celular'           => $this->CELULAR,
        ];
    }
}
