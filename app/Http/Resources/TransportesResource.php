<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransportesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id_user_transporte" => $this->id_user_transporte,
            "id_user" => $this->id_user,
            "nro_placa" => $this->nro_placa,
            "marca" => $this->marca,
            "modelo" => $this->modelo,
            "carnet_circulacion" => $this->carnet_circulacion,
            "carga_maxima" => $this->carga_maxima,
            "fecha_creado" => $this->fecha_creado,
            "fecha_editado" => $this->fecha_editado
        ];
    }
}
