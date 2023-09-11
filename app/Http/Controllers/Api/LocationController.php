<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Locations\LocationRequest;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * @param LocationRequest $request
     * @return JsonResponse
     */
    public function store(LocationRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            /* Creamos el Usuario */
            $location = Location::create($request->validated());
            $location->update([
                'online' => true
            ]);
            $resource = new LocationResource($location);

            DB::commit();

            return $this->sendResponse($resource, 'Online.', 201);

        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        /* Verificar filtro $id, ya que el actual id que se manda es para buscar el user_id
         * cuando debería ser el del transporte asociado al usuario
         * si mandan un ID que no existe, se rompe, verificar
         */
        $transporte = Location::where('user_id', '=', $id)->first();

        if ($transporte === null) {
            return $this->sendError('La Localización asociado al usuario no existe', []);
        }

        $resource = new LocationResource($transporte);
        return $this->sendResponse($resource, 'Localización obtenida exitosamente.');
    }

    /**
     * @param LocationRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(LocationRequest $request, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $location = Location::find($id);

            /* Refactorizar validacion de existencia del ID */

            $location->update($request->validated());
            $resource = new LocationResource($location);

            DB::commit();

            return $this->sendResponse($resource, 'Localización actualizado exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }
}
