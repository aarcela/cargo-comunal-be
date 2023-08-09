<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $username
 * @property mixed $email
 * @property mixed $password
 * @property mixed $activo
 * @property mixed $estado
 * @property mixed $role
 * @property mixed $ruta_image
 * @property mixed $profile
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class UserResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        $routeName = $request->route()->getName();
        $array = array(
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'activo' => $this->activo,
            'estado' => $this->estado,
            'role' => $this->role,
            'ruta_image' => $this->ruta_image,
            'first_name' => $this->profile ? $this->profile->first_name : null,
            'second_name' => $this->profile ? $this->profile->second_name : null,
            'first_surname' => $this->profile ? $this->profile->first_surname : null,
            'second_surname' => $this->profile ? $this->profile->second_surname : null,
            'phone' => $this->profile ? $this->profile->phone : null,
            'ci' => $this->profile ? $this->profile->ci : null,
            'fecha_nc' => $this->profile ? $this->profile->fecha_nc : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        );
        $routeName === 'login' && $array['token'] = $request->get('token');
        return $array;
    }
}
