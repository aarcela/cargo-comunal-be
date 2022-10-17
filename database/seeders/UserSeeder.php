<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'adminVE',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
            'estado' => 'aprobado', // 'pendiente' | 'aprobado' | 'cancelado'
            'role' => 'administrador', // "conductor" | "solicitante" | "administrador" | "analista"
        ]);

        User::create([
            'username' => 'analistVE',
            'email' => 'analist@admin.com',
            'password' => bcrypt('analist123'),
            'estado' => 'aprobado', // 'pendiente' | 'aprobado' | 'cancelado'
            'role' => 'analista', // "conductor" | "solicitante" | "administrador" | "analista"
        ]);
    }
}
