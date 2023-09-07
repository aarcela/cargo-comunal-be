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

class TransporteController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // Parámetros de solicitud disponibles
        $params = $request->only(['query', 'limit', 'page', 'orderBy', 'ascending']);

        // Establecer valores predeterminados si están ausentes o vacíos
        $limit = $params['limit'] ?? 8;
        $page = $params['page'] ?? 1;
        $estado = $params['query'] ?? 'aprobado';

        // Consulta base
        $transports = Transport::whereHas('user', function ($query) {
            $query->where('activo', true);
        })->where('estado', $estado);

        // Contar registros antes de paginar
        $count = $transports->count();

        // Paginar y ordenar si es necesario
        if (isset($params['orderBy'])) {
            $direction = $params['ascending'] == 1 ? 'ASC' : 'DESC';
            $transports->orderBy($params['orderBy'], $direction);
        }

        $results = $transports->skip(($page - 1) * $limit)->take($limit)->get();

        // Recursos y paginación
        $resource = TransportesResource::collection($results);
        $pagination = [
            'numPage' => intval($page),
            'resultPage' => count($results),
            'totalResult' => $count
        ];

        return $this->sendIndexResponse($resource, 'Transportes obtenidos exitosamente.', $pagination);
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
