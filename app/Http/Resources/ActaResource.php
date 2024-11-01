<?php

namespace App\Http\Resources;

use App\Models\Sesion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActaResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'ID_ACTA' => $this->ID_ACTA,
            'ESTADO' => $this->ESTADO,
            'SESION' => $this->whenLoaded('sesion')
        ];
    }
}
