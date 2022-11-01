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
        'usuarios_profile.fecha_nc',
        'usuarios_profile.fecha_creado',  
    ];

    public function index()
    {
        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending']));
        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $estado = ( $query != null && isset($query->estado) && $query->estado != '' ) ? $query->estado : "aprobado";

        $records = User::select($this->userData)
            ->leftJoin('usuarios_profile', 'usuarios_profile.id_user', '=', 'usuarios.id_user')
            ->where('usuarios.activo', '=', true)
            ->where('usuarios.estado', '=', $estado)
            ->where('usuarios.role', '<>', 'administrador')
            ->where('usuarios.role', '<>', 'analista');
        
        $count = $records->count();
        $records->limit($limit)
            ->skip($limit * ($page - 1));

        if (isset($orderBy)) {
            $direction = $ascending == 1 ? 'ASC' : 'DESC';
            $records->orderBy($orderBy, $direction);
        }

        $results = $records->get()->toArray();


        return response()->json([
            'data' => $results,
            'pagination' => [
                'numPage' => intval($page),
                'resultPage' => count($results),
                'totalResult' => $count
            ]
        ], 200);
       
    }

   

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'regex:/^[a-zA-Z0-9_]+$/', 'max:15', 'unique:usuarios'],
            'email' => ['required', 'email', 'unique:usuarios'],
            'password' => ['required', 'min:6', 'max:12'],
            'role' => ['required'],
            'first_name' => ['required', 'max:15'],
            'second_name' => ['max:15'],
            'first_surname' => ['required', 'max:15'],
            'second_surname' => ['max:15'],
            'phone' => ['required', 'regex:/^[0-9]+$/', 'max:11'],
            'ci' => ['required', 'regex:/^[0-9]+$/', 'max:12', 'unique:usuarios_profile'],
            'fecha_nc' => ['required'],
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
        $profile->fecha_nc = Carbon::parse($request->fecha_nc)->format('Y-m-d');
        $profile->save();

        return response()->json([
            'message' => 'Usuario Creado'
        ], 200);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'estado' => ['required'],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'message' => $validator->errors()->first(),
            ], 403);
        }

        $user = User::find($id);

        $user->estado = $request->estado;
        $user->update();

        return response()->json([
            'message' => 'Usuario Actualizado'
        ], 200);
    }
}
