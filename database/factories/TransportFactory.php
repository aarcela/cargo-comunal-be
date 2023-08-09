<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transport>
 */
class TransportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->unique()->randomElement(User::all()->pluck('id')->toArray()),
            'nro_placa' => $this->faker->randomAscii,
            'marca' => $this->faker->city,
            'modelo' => $this->faker->colorName,
            'carnet_circulacion' => $this->faker->numberBetween([100000000, 35000000]),
            'carga_maxima' => $this->faker->numberBetween([1000, 5000]),
            'tipo' => $this->faker->mimeType(),
            'estado' => $this->faker->randomElement(['pendiente', 'aprobado', 'cancelado']),
        ];
    }
}
