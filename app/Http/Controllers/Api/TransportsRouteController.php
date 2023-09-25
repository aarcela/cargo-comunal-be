<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransportesResource;
use App\Models\Transport;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransportsRouteController extends Controller
{
    /**
    * @param Request $request
    * @return JsonResponse
    */
    public function assign_routes(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $assignRoutes = Transport::find($request->get('transport_id'));
            $assignRoutes->routes()->sync($request->get('routes'));
            $resource = new TransportesResource($assignRoutes);

            DB::commit();
            return $this->sendResponse($resource, 'rutas agregadas exitosamente ' . $assignRoutes->name);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }
}




