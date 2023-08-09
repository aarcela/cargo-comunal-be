<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if (Auth::attempt($credentials)) {
            $user = $request->user();

            if (!$user->activo) {
                return $this->sendError('Inactive', ['error' => 'User is inactive'], 403);
            }

            if ($user->estado == 'pendiente' && ($user->role == 'conductor' || $user->role == 'solicitante')) {
                return $this->sendError('Su cuenta se encuentra en los proceso de verificación. Una vez verificada, podrá ingresar.');
            } else if ($user->estado == 'cancelado') {
                return $this->sendError('Lo sentimos, su solicitud fue cancelada, no cuenta con la verificación para poder ingresar.');
            }

            $token = $user->createToken('CargoComunalAppToken')->plainTextToken;
            $request->merge(['token' => $token]);
            $resource = new UserResource($user);

            return $this->sendResponse($resource, 'User logged in successfully.');
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized'], 401);
        }


    }

    public function check_auth(Request $request)
    {
        /*$user = User::select($this->userData)
            ->leftJoin('usuarios_profile', 'usuarios_profile.id_user', '=', 'usuarios.id_user')
            ->where('usuarios.id_user', '=', $request->user()->id_user)
            ->where('usuarios.activo', '=', true)
            ->first();

        return response()->json([
            'user' => $user,
        ], 200);*/
    }

    public function register(Request $request)
    {
        /*$validator = Validator::make($request->all(), [
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
                'message' => $validator->errors()->first(),
            ], 403);
        }

        if ($request->role != 'conductor' && $request->role != 'solicitante') {
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

        $profile = new Profile;
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
            'message' => 'Cuenta Creada'
        ], 200);*/
    }

    public function logout(Request $request)
    {
        /*$request->user()->token()->revoke();
        return response()->json([
            'message' => 'Cerraste sesión',
        ], 200);*/
    }
}
