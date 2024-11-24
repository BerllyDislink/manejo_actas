<?php

namespace App\Http\Resources;
use App\Models\Miembro;
use App\Models\Sesion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProposicionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ID_PROPOSICIONES' => $this->ID_PROPOSICIONES,
            'DESCRIPCION' => $this->DESCRIPCION,
            'DECISION' => $this->DECISION,
            'MIEMBRO_IDMIEMBRO' => $this->whenLoaded('miembro', function () {
                return $this->miembro->IDMIEMBRO;
            }),
            'NOMBRE_MIEMBRO' => $this->whenLoaded('miembro', function () {
                return $this->miembro->users->name ?? 'Nombre no disponible';
            }),
            'EMAIL_MIEMBRO' => $this->whenLoaded('miembro', function () {
                return $this->miembro->users->email ?? 'Correo no disponible';
            }),
            'SESION' => $this->whenLoaded('sesion', function () {
                return $this->sesion; // If you want more fields from 'sesion', you can access them similarly
            }),
        ];
    }
}