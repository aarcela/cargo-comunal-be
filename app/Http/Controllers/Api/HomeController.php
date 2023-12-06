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

        /** User Solicitantes */
        $countUsersSolicitantes = $allUsers->where('role', 'solicitante')->count();
        $countUsersSolicitantesAprobados = $allUsers->where('role', 'solicitante')
            ->where('estado', 'aprobado')
            ->count();
        $countUsersSolicitantesPendientes = $allUsers->where('role', 'solicitante')
            ->where('estado', 'pendiente')
            ->count();
        $countUsersSolicitantesCancelados = $allUsers->where('role', 'solicitante')
            ->where('estado', 'cancelado')
            ->count();

        /** User Conductores */
        $countUsersConductores = $allUsers->where('role', 'conductor')->count();
        $countUsersConductoresAprobados = $allUsers->where('role', 'conductor')
            ->where('estado', 'aprobado')
            ->count();
        $countUsersConductoresPendientes = $allUsers->where('role', 'conductor')
            ->where('estado', 'pendiente')
            ->count();
        $countUsersConductoresCancelados = $allUsers->where('role', 'conductor')
            ->where('estado', 'cancelado')
            ->count();

        /** Viajes */
        $countViajesAprobados = $allViajes->where('status', 'aprobado')->count();
        $countViajesPendientes = $allViajes->where('status', 'pendiente')->count();
        $countViajesCancelados = $allViajes->where('status', 'cancelad0')->count();

        /** Transportistas */
        $countTransportesAprobados = $allTransportes->where('estado', 'aprobado')->count();
        $countTransportesPendientes = $allTransportes->where('estado', 'pendiente')->count();

        /** Resource todos */
        $resource = collect([
            'user_solicitantes' => $countUsersSolicitantes,
            'user_solicitantes_aprobados' => $countUsersSolicitantesAprobados,
            'user_solicitantes_pendientes' => $countUsersSolicitantesPendientes,
            'user_solicitantes_cancelados' => $countUsersSolicitantesCancelados,
            'user_conductores' => $countUsersConductores,
            'user_conductores_aprobados' => $countUsersConductoresAprobados,
            'user_conductores_pendientes' => $countUsersConductoresPendientes,
            'user_conductores_cancelados' => $countUsersConductoresCancelados,
            'viajes_aprobados' => $countViajesAprobados,
            'viajes_pendientes' => $countViajesPendientes,
            'viajes_cancelados' => $countViajesCancelados,
            'transportistas_aprobados' => $countTransportesAprobados,
            'transportistas_pendientes' => $countTransportesPendientes,
            'transportistas_todos' => $allTransportes->count()
        ]);

        return $this->sendResponse($resource, 'Envio de la información del Home con exito!');
    }
}
