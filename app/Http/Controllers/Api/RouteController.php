<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Route\RouteRequest;
use App\Http\Resources\RouteResource;
use App\Models\Route;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $results = Route::all();

        // Recursos y paginación
        $resource = RouteResource::collection($results);
        $pagination = [
            'numPage' => null,
            'resultPage' => null,
            'totalResult' => null
        ];

        return $this->sendIndexResponse($resource, 'Rutas obtenidas exitosamente.', $pagination);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RouteRequest $request
     * @return jsonResponse
     */
    public function store(RouteRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            /* Creamos el Usuario */
            $rutas = Route::create($request->validated());
            $resource = new RouteResource($rutas);

            DB::commit();

            return $this->sendResponse($resource, 'Ruta creada exitosamente.', 201);

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
        $rutas = Route::find($id);

        $resource = new RouteResource($rutas);
        return $this->sendResponse($resource, 'Ruta obtenida exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RouteRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(RouteRequest $request, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $rutas = Route::find($id);

            /* Refactorizar validacion de existencia del ID */

            $rutas->update($request->validated());
            $resource = new RouteResource($rutas);

            DB::commit();

            return $this->sendResponse($resource, 'Ruta actualizado exitosamente.');
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

            $rutas = Route::find($id);
            $rutas->delete();

            DB::commit();
            return $this->sendResponse([], 'Ruta eliminada con exito.');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }

    }













}
