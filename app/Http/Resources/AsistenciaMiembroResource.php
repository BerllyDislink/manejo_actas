<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AsistenciaMiembroResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'estado' => $this->ESTADO_ASISTENCIA,
            'sesion' => $this->whenLoaded('sesion'),
            "miembro" => $this->whenLoaded('miembro')
        ];
    }
}
