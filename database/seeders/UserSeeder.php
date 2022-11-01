<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UsuariosProfile;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userAdmin = new User;
        $userAdmin->username = 'adminVE';
        $userAdmin->email = 'admin@admin.com';
        $userAdmin->password = bcrypt('admin123');
        $userAdmin->estado = 'aprobado'; // 'pendiente' | 'aprobado' | 'cancelado'
        $userAdmin->role = 'administrador';  // "conductor" | "solicitante" | "administrador" | "analista"
        $userAdmin->save();

        $profileAdmin = new UsuariosProfile();
        $profileAdmin->id_user = $userAdmin->id_user;
        $profileAdmin->first_name = 'Juan';
        $profileAdmin->second_name = 'Alejandro';
        $profileAdmin->first_surname = 'Parra';
        $profileAdmin->second_surname = 'Gomez';
        $profileAdmin->phone = '4269174862';
        $profileAdmin->ci = '9740401';
        $profileAdmin->fecha_nc = Carbon::parse('2022-01-1')->format('Y-m-d');
        $profileAdmin->save();

        $userAnalist = new User;
        $userAnalist->username = 'analistVE';
        $userAnalist->email = 'analist@admin.com';
        $userAnalist->password = bcrypt('analist123');
        $userAnalist->estado = 'aprobado'; // 'pendiente' | 'aprobado' | 'cancelado'
        $userAnalist->role = 'analista'; // "conductor" | "solicitante" | "administrador" | "analista"
        $userAnalist->save();

        $profileAnalist = new UsuariosProfile();
        $profileAnalist->id_user = $userAnalist->id_user;
        $profileAnalist->first_name = 'Carlos';
        $profileAnalist->second_name = 'Frank';
        $profileAnalist->first_surname = 'Angulo';
        $profileAnalist->second_surname = 'Pereira';
        $profileAnalist->phone = '4269174862';
        $profileAnalist->ci = '10980801';
        $profileAnalist->fecha_nc = Carbon::parse('2022-01-1')->format('Y-m-d');
        $profileAnalist->save();
        
    }
}
