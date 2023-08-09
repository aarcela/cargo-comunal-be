<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomElement(User::all()->pluck('id')->toArray()),
            'first_name' => $this->faker->firstName,
            'second_name' => $this->faker->firstName,
            'first_surname' => $this->faker->lastName,
            'second_surname' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'ci' => $this->faker->uuid,
            'fecha_nc' => $this->faker->dateTimeBetween('-8000 days', '-6000 days'),
        ];


    }
}
