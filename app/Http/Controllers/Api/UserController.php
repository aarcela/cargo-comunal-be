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
use App\Models\User;
use App\Models\Profile;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        /* // Parámetros de solicitud disponibles
         $params = $request->only(['query', 'limit', 'page', 'orderBy', 'ascending']);

         // Establecer valores predeterminados si están ausentes o vacíos
         $limit = $params['limit'] ?? 8;
         $page = $params['page'] ?? 1;
         $estado = $params['query'] ?? 'aprobado';

         // Consulta base
         $users = User::where('activo', true)
             ->where('estado', $estado)
             ->whereNotIn('role', ['administrador', 'analista']);

         // Contar registros antes de paginar
         $count = $users->count();

         // Paginar y ordenar si es necesario
         if (isset($params['orderBy'])) {
             $direction = $params['ascending'] == 1 ? 'ASC' : 'DESC';
             $users->orderBy($params['orderBy'], $direction);
         }

         $results = $users->skip(($page - 1) * $limit)->take($limit)->get();*/

        $results = User::all();

        // Recursos y paginación
        $resource = UserResource::collection($results);
        $pagination = [
            'numPage' => null,
            'resultPage' => null,
            'totalResult' => null
        ];

        return $this->sendIndexResponse($resource, 'Usuarios obtenidos exitosamente.', $pagination);
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

            return $this->sendResponse($resource, 'Usuario creado exitosamente.', 201);

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
