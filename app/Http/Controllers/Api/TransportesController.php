<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transports\TemporaryTransportUpdateRequest;
use App\Http\Requests\Transports\TransporteRequest;
use App\Http\Resources\TransportesResource;
use App\Models\Transport;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransportesController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(request $request): JsonResponse
    {
        /* Lista de los Requests..
            - query
            - limit
            - page
            - orderBy
            - ascending
        */

        extract($request->only(['query', 'limit', 'page', 'orderBy', 'ascending']));
        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $estado = ($query != null && isset($query->estado) && $query->estado != '') ? $query->estado : "aprobado";

        $records = Transport::whereHas('user', function ($query) {
            /* El query usado dentro de la funcion, es distinto (Para tener en cuenta) */
            $query->where('activo', '=', true);
        })->where('estado', '=', $estado);

        $count = $records->count();
        $records->limit($limit)
            ->skip($limit * ($page - 1));

        if (isset($orderBy)) {
            $direction = $ascending == 1 ? 'ASC' : 'DESC';
            $records->orderBy($orderBy, $direction);
        }

        $results = $records->get();
        $resource = TransportesResource::collection($results);
        $pagination = [
            'numPage' => intval($page),
            'resultPage' => count($results),
            'totalResult' => $count
        ];

        return $this->sendIndexResponse($resource, 'Transporte creado exitosamente.', $pagination);
    }

    /**
     * @param TransporteRequest $request
     * @return JsonResponse
     */
    public function store(TransporteRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            /* Creamos el Usuario */
            $transport = Transport::create($request->validated());
            $resource = new TransportesResource($transport);

            DB::commit();

            return $this->sendResponse($resource, 'Transporte creado exitosamente.', 201);

        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        /* Verificar filtro $id, ya que el actual id que se manda es para buscar el user_id
         * cuando debería ser el del transporte asociado al usuario
         * si mandan un ID que no existe, se rompe, verificar
         */
        $transporte = Transport::whereHas('user', function ($query) {
            /* El query usado dentro de la funcion, es distinto (Para tener en cuenta) */
            $query->where('activo', '=', true);
        })->where('user_id', '=', $id)->first();

        if ($transporte === null) {
            $this->sendError('El transporte asociado al usuario no existe');
        }

        $resource = new TransportesResource($transporte);
        return $this->sendResponse($resource, 'Transporte obtenido exitosamente.');
    }

    /**
     * @param $id
     * @param TemporaryTransportUpdateRequest $request
     * @return JsonResponse
     */
    public function update($id, TemporaryTransportUpdateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $transporte = Transport::find($id);

            /* Refactorizar validacion de existencia del ID */

            $transporte->update([
                'estado' => $request->get('estado')
            ]);
            $resource = new TransportesResource($transporte);

            DB::commit();

            return $this->sendResponse($resource, 'Transporte actualizado exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }

    }
}
