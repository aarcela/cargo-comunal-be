<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UsuariosProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:12']
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'message' => $validator->errors()->first(),
            ], 403);
        }

        $user = User::select($this->userData)
            ->leftJoin('usuarios_profile', 'usuarios_profile.id_user', '=', 'usuarios.id_user')
            ->where('usuarios.email', '=', $request->email)
            ->first();

        if( $user != null ){
            if( $user->estado == 'pendiente' && ( $user->role == 'conductor' || $user->role == 'solicitante' ) ){
                return response()->json([
                    'status' => 401,
                    'message' => 'Su cuenta se encuentra en los proceso de verificación. Una vez verficada, podrá ingresar.'
                ], 401);
            }else if( $user->estado == 'cancelado' ){
                return response()->json([
                    'status' => 401,
                    'message' => 'Lo sentimos, su solicitud fue cancelada, no cuenta con la verificación para poder ingresar.'
                ], 401);
            }
        }

        if (!$token=Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => 401,
                'message' => 'Correo electrónico o contraseña incorrecta'
            ], 401);
        }

        $tokenResult = $request->user()->createToken('Personal Access Client');
        $token = $tokenResult->token; 
        $token->expires_at = Carbon::now()->addDay(1);         
        $token->save(); 

        return response()->json([
            'status' => 200,
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
        ], 200);

    }

    public function check_auth(Request $request)
    {
        $user = User::select($this->userData)
            ->leftJoin('usuarios_profile', 'usuarios_profile.id_user', '=', 'usuarios.id_user')
            ->where('usuarios.id_user', '=',  $request->user()->id_user)
            ->where('usuarios.activo', '=', true)
            ->first();
            
        return response()->json([
            'status' => 200,
            'user' => $user,
        ], 200);
    }

    public function register(Request $request){
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

        if( $request->role != 'conductor' && $request->role != 'solicitante' ){
            return response()->json([
                'status' => 403,
                'message' => 'Los valores del campo rol no son los correctos',
            ], 403);
        }

        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
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
            'status' => 200,
            'message' => 'Cuenta Creada'
        ], 200);
    }
}
