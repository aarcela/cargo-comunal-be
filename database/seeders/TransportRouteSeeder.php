<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\Transport;
use Illuminate\Database\Seeder;

class TransportRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $transports = Transport::get();
        foreach ($transports as $transport) {
            $route_id = Route::select('id')->get()->random()->id;
            $transport->routes()->attach($route_id);
        }
    }
}
