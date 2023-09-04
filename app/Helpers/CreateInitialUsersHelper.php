<?php

use App\Models\User;
use Carbon\Carbon;

if (!function_exists('CreateInitialUsersHelper')) {

    /**
     * @return void
     */
    function CreateInitialUsersHelper(): void
    {
        /* Creamos el usuario administrador */
        $adminUser = User::create([
            'username' => 'adminVE',
            'email' => 'admin@admin.com',
            'password' => 'admin123',
            'estado' => 'aprobado', // 'pendiente' | 'aprobado' | 'cancelado'
            'role' => 'administrador', // "conductor" | "solicitante" | "administrador" | "analista"
        ]);

        $adminUser->profile()->create([
            'user_id' => $adminUser->id,
            'first_name' => 'Juan',
            'second_name' => 'Alejandro',
            'first_surname' => 'Parra',
            'second_surname' => 'Gomez',
            'phone' => '4269174862',
            'ci' => '9740401',
            'fecha_nc' => Carbon::parse('1995-01-1')->format('Y-m-d'),
        ]);

        /* Creamos el usuario analista */
        $analystUser = User::create([
            'username' => 'analystVE',
            'email' => 'analist@admin.com',
            'password' => 'analyst123',
            'estado' => 'aprobado', // 'pendiente' | 'aprobado' | 'cancelado'
            'role' => 'analista', // "conductor" | "solicitante" | "administrador" | "analista"
        ]);

        $analystUser->profile()->create([
            'user_id' => $analystUser->id,
            'first_name' => 'Carlos',
            'second_name' => 'Frank',
            'first_surname' => 'Angulo',
            'second_surname' => 'Pereira',
            'phone' => '4269174862',
            'ci' => '10980801',
            'fecha_nc' => Carbon::parse('1995-01-1')->format('Y-m-d'),
        ]);

        /* Creamos el usuario solicitante */
        $solicitanteUser = User::create([
            'username' => 'solicitanteVE',
            'email' => 'solicitante@admin.com',
            'password' => 'solicitante123',
            'estado' => 'aprobado', // 'pendiente' | 'aprobado' | 'cancelado'
            'role' => 'solicitante', // "conductor" | "solicitante" | "administrador" | "analista"
        ]);

        $solicitanteUser->profile()->create([
            'user_id' => $solicitanteUser->id,
            'first_name' => 'Luis',
            'second_name' => 'Alejandro',
            'first_surname' => 'Salazar',
            'second_surname' => 'Santana',
            'phone' => '4264567850',
            'ci' => '16468690',
            'fecha_nc' => Carbon::parse('1995-01-1')->format('Y-m-d'),
        ]);

        /* Creamos el usuario conductor */
        $conductorUser = User::create([
            'username' => 'conductorVE',
            'email' => 'conductor@admin.com',
            'password' => 'conductor123',
            'estado' => 'aprobado', // 'pendiente' | 'aprobado' | 'cancelado'
            'role' => 'conductor', // "conductor" | "solicitante" | "administrador" | "analista"
        ]);

        $conductorUser->profile()->create([
            'user_id' => $conductorUser->id,
            'first_name' => 'Jean',
            'second_name' => 'Pier',
            'first_surname' => 'Ramos',
            'second_surname' => 'Velara',
            'phone' => '4244958611',
            'ci' => '12492850',
            'fecha_nc' => Carbon::parse('1995-01-1')->format('Y-m-d'),
        ]);
    }
}
