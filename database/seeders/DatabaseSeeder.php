<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        /* Funcion para crear los usuarios iniciales */
        CreateInitialUsersHelper();

        $this->call([
            UserSeeder::class,
            ProfileSeeder::class,
            TransportSeeder::class,
            LocationSeeder::class,
            ViajesSeeder::class
        ]);
    }
}
