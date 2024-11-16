<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SesionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->IDSESION,
            'lugar'         => $this->LUGAR,
            'fecha'         => $this->FECHA,
            'hora_inicio'   => $this->HORARIO_INICIO,
            'hora_final'    => $this->HORARIO_FINAL,
            'presidente'    => $this->PRESIDENTE,
            'secretario'    => $this->SECRETARIO,
        ];
    }
}
