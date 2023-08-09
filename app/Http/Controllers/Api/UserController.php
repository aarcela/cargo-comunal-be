<?php

namespace App\Http\Controllers\Api;

use App\Concerns\Classes\ModelErrors;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\TemporaryUserUpdateRequest;
use App\Http\Requests\Users\UserRequest;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Profile;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {





        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending']));
        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $estado = ($query != null && isset($query->estado) && $query->estado != '') ? $query->estado : "aprobado";

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


    /**
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        /*
         * Roles de Usuario
         * conductor, solicitante, administrador, analista
         **/

        try {
            DB::beginTransaction();

            $user = Auth::user();
            if ($user->role === 'analista' && ($request->get('role') !== 'conductor' && $request->get('role') !== 'solicitante')) {
                return $this->sendError('usted no tiene permiso para crear usuario ' . $request->get('role'), [], 403);
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

            return $this->sendResponse($resource, 'Usuario creado exitosamente.');

        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function update(TemporaryUserUpdateRequest $request, int $id): JsonResponse
    {
        $modelErrors = new ModelErrors($id, User::class, 'Usuario');
        $processErrorLogic = $modelErrors->processErrorLogic();
        if ($processErrorLogic === true) {
            try {
                DB::beginTransaction();
                $user = User::find($id);
                $user->update([
                    'estado' => $request->get('estado'),
                ]);
                $resource = new UserResource($user);

                DB::commit();
                return $this->sendResponse($resource, 'Usuario actualizado con exito.');
            } catch (Exception $e) {
                DB::rollBack();
                return $this->sendError($e->getMessage());
            }
        } else {
            return $processErrorLogic;
        }
    }
}
