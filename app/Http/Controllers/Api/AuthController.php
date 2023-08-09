<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Users\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
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
            request()->merge(['token' => $token]);
            $resource = new UserResource($user);

            return $this->sendResponse($resource, 'El usuario inició sesión de manera exitosa');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'No autorizado'], 401);
        }


    }

    /**
     * @return JsonResponse|void
     */
    public function verify()
    {
        if (Auth::user() === null) {
            return $this->sendError('Unauthorised.', ['error' => 'No Autorizado'], 401);
        }
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function register(UserRequest $request): JsonResponse
    {
        if ($request->get('role') !== 'conductor' && $request->get('role') !== 'solicitante') {
            return $this->sendError('Los valores del campo rol no son los correctos', [], 403);
        }

        /* Creamos el Usuario */
        $user = User::create($request->validated());

        /* Valores por defecto */
        $user->update([
            'activo' => true,
            'estado' => 'pendiente'
        ]);

        /* Creamos el Profile del Usuario */
        $profile = Profile::create($request->validated());
        $profile->update([
            'user_id' => $user->id
        ]);

        $resource = new UserResource($user);

        DB::commit();

        return $this->sendResponse($resource, 'Cuenta Creada exitosamente.');
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return $this->sendResponse('Message', 'El usuario cerro sesión de manera exitosa');
    }
}
