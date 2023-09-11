<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $user_id
 * @property mixed $user
 * @property mixed $transport_id
 * @property mixed $transpot
 * @property mixed $ruta
 * @property mixed $tiempo
 * @property mixed $hora
 * @property mixed $peso
 * @property mixed $status
 * @property mixed $latitud_origen
 * @property mixed $longitud_origen
 * @property mixed $latitud_destino
 * @property mixed $id
 */
class ViajesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id ? new UserResource($this->user) : null ,
            "transport_id" => $this->transport_id ? new TransportesResource($this->transpot) : null ,
            "ruta" => $this->ruta ,
            "tiempo" => $this->tiempo,
            "hora" => $this->hora,
            "peso" => $this->peso,
            "status" => $this->status,
            "latitud_origen" => $this->latitud_origen,
            "longitud_origen" => $this->longitud_origen,
            "latitud_destino" => $this->latitud_destino
        ];
    }
}
