<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $userAdmin = new User;
        $userAdmin->username = 'adminVE';
        $userAdmin->email = 'admin@admin.com';
        $userAdmin->password = bcrypt('admin123');
        $userAdmin->estado = 'aprobado'; // 'pendiente' | 'aprobado' | 'cancelado'
        $userAdmin->role = 'administrador';  // "conductor" | "solicitante" | "administrador" | "analista"
        $userAdmin->save();

        $profileAdmin = new Profile();
        $profileAdmin->user_id = $userAdmin->id;
        $profileAdmin->first_name = 'Juan';
        $profileAdmin->second_name = 'Alejandro';
        $profileAdmin->first_surname = 'Parra';
        $profileAdmin->second_surname = 'Gomez';
        $profileAdmin->phone = '4269174862';
        $profileAdmin->ci = '9740401';
        $profileAdmin->fecha_nc = Carbon::parse('1995-01-1')->format('Y-m-d');
        $profileAdmin->save();

        $useranalyst = new User;
        $useranalyst->username = 'analystVE';
        $useranalyst->email = 'analist@admin.com';
        $useranalyst->password = bcrypt('analyst123');
        $useranalyst->estado = 'aprobado'; // 'pendiente' | 'aprobado' | 'cancelado'
        $useranalyst->role = 'analista'; // "conductor" | "solicitante" | "administrador" | "analista"
        $useranalyst->save();

        $profileanalyst = new Profile();
        $profileanalyst->user_id = $useranalyst->id;
        $profileanalyst->first_name = 'Carlos';
        $profileanalyst->second_name = 'Frank';
        $profileanalyst->first_surname = 'Angulo';
        $profileanalyst->second_surname = 'Pereira';
        $profileanalyst->phone = '4269174862';
        $profileanalyst->ci = '10980801';
        $profileanalyst->fecha_nc = Carbon::parse('1995-01-1')->format('Y-m-d');
        $profileanalyst->save();

    }
}
