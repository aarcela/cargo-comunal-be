<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Viajes\ViajesRequest;
use App\Http\Requests\Viajes\ViajeUpdateStatusRequest;
use App\Http\Resources\ViajesResource;
use App\Models\Viajes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class ViajesController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {

        /*// Parámetros de solicitud disponibles
        $params = $request->only(['query', 'limit', 'page', 'orderBy', 'ascending']);

        // Establecer valores predeterminados si están ausentes o vacíos
        $limit = $params['limit'] ?? 8;
        $page = $params['page'] ?? 1;
        $estado = $params['query'] ?? 'aprobado';

        // Consulta base
        $viajes = Viajes::whereHas('user', function ($query) {
            $query->where('activo', true);
        })->where('status', $estado);

        // Contar registros antes de paginar
        $count = $viajes->count();

        // Paginar y ordenar si es necesario
        if (isset($params['orderBy'])) {
            $direction = $params['ascending'] == 1 ? 'ASC' : 'DESC';
            $viajes->orderBy($params['orderBy'], $direction);
        }

        $results = $viajes->skip(($page - 1) * $limit)->take($limit)->get();*/

        $results = Viajes::all();

        // Recursos y paginación
        $resource = ViajesResource::collection($results);
        $pagination = [
            'numPage' => null,
            'resultPage' => null,
            'totalResult' => null
        ];

        return $this->sendIndexResponse($resource, 'Viajes obtenidos exitosamente.', $pagination);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ViajesRequest $request
     * @return jsonResponse
     */
    public function store(ViajesRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            /* Creamos el Viaje */
            $viajes = Viajes::create($request->validated());
            $resource = new ViajesResource($viajes);

            DB::commit();

            return $this->sendResponse($resource, 'Viaje creado exitosamente.', 201);

        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $viajes = Viajes::whereHas('user', function ($query) {
            $query->where('activo', '=', true);
        })->where('id', '=', $id)->first();

        if ($viajes === null) {
            return $this->sendError('La solicitud de viaje no existe');
        }

        $resource = new ViajesResource($viajes);
        return $this->sendResponse($resource, 'viaje obtenido exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ViajesRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ViajesRequest $request, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $viajes = Viajes::find($id);

            /* Refactorizar validacion de existencia del ID */

            $viajes->update($request->validated());
            $resource = new ViajesResource($viajes);

            DB::commit();

            return $this->sendResponse($resource, 'Viaje actualizado exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function updateStatus($id, ViajeUpdateStatusRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $viajes = Viajes::find($id);

            if ($viajes->status === 'cancelado') {
                if ($viajes->cantidad_rechazos < 2) {
                    $viajes->update([
                        'cantidad_rechazos' => $viajes->cantidad_rechazos + 1,
                    ]);
                }else{
                    $viajes->update(['status' => 'pendiente']);
                    DB::commit();
                    return $this->sendResponse([], 'asignar status manualmente');
                }

                $resource = [
                    'cantidad_rechazos' => $viajes->cantidad_rechazos
                ];
                DB::commit();
                return $this->sendResponse($resource, 'cantidad de rechazos');
            }
                $viajes->update($request->validated());
                $resource = new ViajesResource($viajes);

            DB::commit();
            return $this->sendResponse($resource, 'Estado actualizado exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $viaje = Viajes::find($id);
            $viaje->delete();

            DB::commit();
            return $this->sendResponse([], 'Viaje eliminado con exito.');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }

    }
}
