<?php

namespace Database\Factories;

use App\Models\Transport;
use App\Models\Viajes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Viajes>
 */
class ViajesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Viajes::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $estados = ['pendiente', 'aprobado', 'cancelado'];
        $notAllowedUsers = [1, 2, 3];
        $allowedUserIds = User::whereNotIn('id', $notAllowedUsers)->pluck('id')->toArray();
        $transportIds = Transport::all();

        return [
            'user_id' => $this->faker->randomElement($allowedUserIds),
            'transport_id' => $this->faker->randomElement($transportIds),
            'ruta' =>  $this->faker->address,
            'tiempo' => $this->faker->date,
            'hora' => $this->faker->time,
            'peso' => $this->faker->numberBetween([1000, 5000]),
            'status' => $this->faker->randomElement($estados),
            'latitud_origen' => $this->faker->latitude,
            'longitud_origen' => $this->faker->longitude,
            'latitud_destino' => $this->faker->latitude,
            'longitud_destino' => $this->faker->longitude,
        ];
    }
}
