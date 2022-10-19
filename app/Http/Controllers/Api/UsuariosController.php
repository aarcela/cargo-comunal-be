<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UsuariosProfile;
use Carbon\Carbon;

class UsuariosController extends Controller
{
    public $userData = [
        'usuarios.id_user', 
        'usuarios.username',
        'usuarios.email',
        'usuarios.activo',
        'usuarios.estado', // 'pendiente' | 'aprobado' | 'cancelado'
        'usuarios.role', // "conductor" | "solicitante" | "administrador" | "analista"
        'usuarios.ruta_image',
        'usuarios_profile.first_name',
        'usuarios_profile.second_name',
        'usuarios_profile.first_surname',
        'usuarios_profile.second_surname',
        'usuarios_profile.phone',
        'usuarios_profile.ci',
        'usuarios_profile.fecha_creado', 
    ];

    public function index()
    {
        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending']));
        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'regex:/^[a-zA-Z0-9_]+$/', 'max:15', 'unique:usuarios'],
            'email' => ['required', 'email', 'unique:usuarios'],
            'password' => ['required', 'min:6', 'max:12'],
            'role' => ['required'],
            'first_name' => ['required', 'max:15'],
            'second_name' => ['required', 'max:15'],
            'first_surname' => ['required', 'max:15'],
            'second_surname' => ['required', 'max:15'],
            'phone' => ['required', 'regex:/^[0-9]+$/', 'max:11'],
            'ci' => ['required', 'regex:/^[0-9]+$/', 'max:12', 'unique:usuarios_profile'],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'message' => $validator->errors()->first(),
            ], 403);
        }

        $userAuth = $request->user();

        if( $userAuth->role == 'analista' && ($request->role != 'conductor' && $request->role != 'solicitante') ){
            return response()->json([
                'status' => 403,
                'message' => 'usted no tiene persmiso para crear usuario "'.$request->role.'"',
            ], 403);
        }

        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->estado = 'aprobado';
        $user->save();

        $profile = new UsuariosProfile;
        $profile->id_user = $user->id_user;
        $profile->first_name = $request->first_name;
        $profile->second_name = $request->second_name;
        $profile->first_surname = $request->first_surname;
        $profile->second_surname = $request->second_surname;
        $profile->phone = $request->phone;
        $profile->ci = $request->ci;
        $profile->save();

        return response()->json([
            'message' => 'Usuario Creado'
        ], 200);
    }
}
