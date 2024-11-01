<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TareaResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "ID" => $this->IDTAREAS,
            "DESCRIPCION" => $this->DESCRIPCION,
            "FECHA_ENTREGA" => $this->FECHA_ENTREGA,
            "SESION" => $this->whenLoaded('sesion')
        ];
    }
}
