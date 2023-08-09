<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $user
 * @property mixed $online
 * @property mixed $latitude
 * @property mixed $longitude
 * @property mixed $connection_time
 * @property mixed $connection_date
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class LocationResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "user" => $this->user_id ? new UserResource($this->user) : null,
            "online" => $this->online,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "connection_time" => $this->connection_time,
            "connection_date" => $this->connection_date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
