<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UsuariosTransportes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TransportesController extends Controller
{
    public $userTransportData = [
        'usuarios_transportes.id_user_transporte',
        'usuarios_transportes.nro_placa',
        'usuarios_transportes.marca',
        'usuarios_transportes.modelo',
        'usuarios_transportes.carnet_circulacion',
        'usuarios_transportes.carga_maxima',
        'usuarios_transportes.tipo',
        'usuarios_transportes.fecha_creado AS fecha_creado_transport',
        'usuarios_transportes.estado AS estado_transporte',
        'usuarios.id_user', 
        'usuarios.username',
        'usuarios.email',
        'usuarios.activo',
        'usuarios.estado', // 'pendiente' | 'aprobado' | 'cancelado'
        'usuarios.role', // "conductor" | "solicitante" | "administrador" | "analista"
        'usuarios.ruta_image',
        'usuarios_profile.first_name',
        'usuarios_profile.second_name',
        'usuarios_profile.first_surname',
        'usuarios_profile.second_surname',
        'usuarios_profile.phone',
        'usuarios_profile.ci',
        'usuarios_profile.fecha_nc',
        'usuarios_profile.fecha_creado',  
    ];

    public function index()
    {
        extract(request()->only(['query', 'limit', 'page', 'orderBy', 'ascending']));
        $limit = (isset($limit) && $limit != '') ? $limit : 8;
        $page = (isset($page) && $page != 1) ? $page : 1;
        $query = isset($query) ? json_decode($query) : null;

        $estado = ( $query != null && isset($query->estado) && $query->estado != '' ) ? $query->estado : "aprobado";

        $records = UsuariosTransportes::select($this->userTransportData)
            ->leftJoin('usuarios', 'usuarios.id_user', '=', 'usuarios_transportes.id_user') 
            ->leftJoin('usuarios_profile', 'usuarios_profile.id_user', '=', 'usuarios.id_user')
            ->where('usuarios.activo', '=', true)
            ->where('usuarios_transportes.estado', '=', $estado);
        
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nro_placa' => ['required', 'max:20', 'unique:usuarios_transportes'],
            'marca' => ['required', 'max:20'],
            'modelo' => ['required', 'max:20'],
            'carnet_circulacion' => ['required', 'unique:usuarios_transportes'],
            'carga_maxima' => ['required', 'max:20'],
            'id_user' => ['required'],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'message' => $validator->errors()->first(),
            ], 403);
        }

        $transporte = new UsuariosTransportes;
        $transporte->id_user = $request->id_user;
        $transporte->nro_placa = $request->nro_placa;
        $transporte->marca = $request->marca;
        $transporte->modelo = $request->modelo;
        $transporte->carnet_circulacion = $request->carnet_circulacion;
        $transporte->carga_maxima = $request->carga_maxima;

        $transporte->save();

        return response()->json([
            'message' => 'transporte Creado',
            'data' => $transporte
        ], 200);
    }

    public function show($id)
    {
        $transporte = UsuariosTransportes::select($this->userTransportData)
        ->leftJoin('usuarios', 'usuarios.id_user', '=', 'usuarios_transportes.id_user') 
        ->leftJoin('usuarios_profile', 'usuarios_profile.id_user', '=', 'usuarios.id_user')
        ->where('usuarios.activo', '=', true)
        ->where('usuarios_transportes.id_user', '=', $id)->first();

        return response()->json([
            'data' => $transporte
        ], 200);
    }

    public function update($id, Request $request)
    {
        $transporte = UsuariosTransportes::find($id);

        if( $transporte != null ){
            $validator = Validator::make($request->all(), [
                'estado' => ['required']
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 403,
                    'message' => $validator->errors()->first(),
                ], 403);
            }

            $transporte->estado = $request->estado;
            $transporte->update();

            return response()->json([
                'message' => 'transporte Actualizado',
                'data' => $transporte
            ], 200);
        }else{
            return response()->json([
                'message' => 'este transporte no existe'
            ], 403);
        }
    }
}
