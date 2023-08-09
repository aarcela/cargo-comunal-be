<?php

namespace Database\Factories;

use App\Models\Transport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class TransportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement(User::all()->pluck('id')->toArray()),
            'nro_placa' => $this->faker->postcode,
            'marca' => $this->faker->city,
            'modelo' => $this->faker->colorName,
            'carnet_circulacion' => $this->faker->numberBetween([100000000, 35000000]),
            'carga_maxima' => $this->faker->numberBetween([1000, 5000]),
            'tipo' => $this->faker->mimeType(),
            'estado' => $this->faker->randomElement(['pendiente', 'aprobado', 'cancelado']),
        ];
    }
}
