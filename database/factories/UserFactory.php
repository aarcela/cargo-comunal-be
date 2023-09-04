<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    /**
     * @return array
     */
    public function definition(): array
    {
        $estados = ['pendiente', 'aprobado', 'cancelado'];
        $roles = ['conductor', 'solicitante', 'analista'];
        return [
            'username' => $this->faker->userName,
            'email' => $this->faker->email,
            'password' => 'password',
            'estado' => $this->faker->randomElement($estados),
            'role' => $this->faker->randomElement($roles),
        ];
    }
}
