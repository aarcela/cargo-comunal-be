<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $nombre
 * @property mixed $description
 * @property mixed $transport
 */
class RouteResource extends JsonResource
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
            "nombre" => $this->nombre,
            "description" => $this->description,
            "transporte" => $this->transport ? new TransportesResource($this->transport->transport) : null,
        ];
    }
}
