<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transport;
use App\Models\User;
use App\Models\Viajes;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function home(): JsonResponse
    {
        $allUsers = User::all();
        $allViajes = Viajes::all();
        $allTransportes = Transport::all();

        $countUsersSolicitantes = $allUsers->where('role', 'solicitante')->count();
        $countUsersConductores = $allUsers->where('role', 'conductor')->count();

        $countViajesAprobados = $allViajes->where('status', 'aprobado')->count();
        $countViajesPendientes = $allViajes->where('status', 'pendiente')->count();
        $countViajesCancelados = $allViajes->where('status', 'cancelad0')->count();


        $countTransportesAprobados = $allTransportes->where('estado', 'aprobado')->count();
        $countTransportesPendientes = $allTransportes->where('estado', 'pendiente')->count();


        $resource = collect([
            'solicitantes' => $countUsersSolicitantes,
            'conductores' => $countUsersConductores,
            'viajes_aprobados' => $countViajesAprobados,
            'viajes_pendientes' => $countViajesPendientes,
            'viajes_cancelados' => $countViajesCancelados,
            'transportistas_aprobados' => $countTransportesAprobados,
            'transportistas_pendientes' => $countTransportesPendientes,
        ]);

        return $this->sendResponse($resource, 'Envio de la información del Home con exito!');
    }
}
