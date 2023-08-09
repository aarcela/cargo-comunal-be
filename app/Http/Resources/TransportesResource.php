<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $user
 * @property mixed $nro_placa
 * @property mixed $marca
 * @property mixed $modelo
 * @property mixed $carnet_circulacion
 * @property mixed $carga_maxima
 * @property mixed $tipo
 * @property mixed $estado
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class TransportesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user" => $this->user_id ? new UserResource($this->user) : null,
            "nro_placa" => $this->nro_placa,
            "marca" => $this->marca,
            "modelo" => $this->modelo,
            "carnet_circulacion" => $this->carnet_circulacion,
            "carga_maxima" => $this->carga_maxima,
            "tipo" => $this->tipo,
            "estado" => $this->estado,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
