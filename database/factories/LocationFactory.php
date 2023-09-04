<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $notAllowedUsers = [1, 2, 3];
        $allowedUserIds = User::whereNotIn('id', $notAllowedUsers)->pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($allowedUserIds),
            'online' => $this->faker->boolean,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'connection_time' => $this->faker->time,
            'connection_date' => $this->faker->dateTimeBetween('-30 days', '+1 days'),
        ];
    }
}
