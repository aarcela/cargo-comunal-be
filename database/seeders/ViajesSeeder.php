<?php

namespace Database\Seeders;

use App\Models\Viajes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ViajesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Viajes::factory()->count(6)->create();
    }
}
