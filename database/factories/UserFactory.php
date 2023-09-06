<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

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
