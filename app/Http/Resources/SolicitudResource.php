<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitudResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->ID_SOLICITUD,
            'dependencia'       => $this->DEPENDENCIA,
            'asunto'            => $this->ASUNTO,
            'desicion'          => $this->DESICION,
            'fecha_solicitud'   => $this->FECHA_DE_SOLICITUD,
            'sesion_id'         => $this->SESION_IDSESION,
            'solicitante_id'    => $this->SOLICITANTE_IDSOLICITANTE,
            'descripcion_id'    => $this->DESCRIPCION_IDDESCRIPCION,
            'solicitante'       => new SolicitanteResource($this->whenLoaded('solicitante')),
            'descripcion'       => new DescripcionResource($this->whenLoaded('descripcion')),
        ];
    }
}
