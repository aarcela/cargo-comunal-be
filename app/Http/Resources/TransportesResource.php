<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $nro_placa
 * @property mixed $marca
 * @property mixed $modelo
 * @property mixed $carnet_circulacion
 * @property mixed $carga_maxima
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class TransportesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "nro_placa" => $this->nro_placa,
            "marca" => $this->marca,
            "modelo" => $this->modelo,
            "carnet_circulacion" => $this->carnet_circulacion,
            "carga_maxima" => $this->carga_maxima,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
