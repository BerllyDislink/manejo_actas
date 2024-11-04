<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DescripcionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->ID_DESCRIPCION,
            'estudiantes'           => $this->ESTU_IMPLICADOS,
            'numero_estudiantes'    => $this->NUM_ESTU_IMPLICADOS,
            'docentes'              => $this->DOCEN_IMPLICADOS,
            'numero_docentes'       => $this->NUM_DOCEN_IMPLICADOS,
            'ciudad'                => $this->PAIS_IMPLICADO,
            'evento'                => $this->EVENTO,
        ];
    }
}
