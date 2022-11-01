<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UsuariosLocation;
use Carbon\Carbon;

class UsuariosLocationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => ['required'],
            'latitude' => ['required', 'max:40'],
            'longitude' => ['required', 'max:40'],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'message' => $validator->errors()->first(),
            ], 403);
        }

        UsuariosLocation::create([
            'id_user' => $request->id_user,
            'online' => true,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json([
            'message' => 'Online'
        ], 200);
    }

    public function show($id)
    {
        return response()->json([
            'data' => UsuariosLocation::where('id_user', '=', $id)->first()
        ], 200);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'online' => ['required'],
            'latitude' => ['required', 'max:40'],
            'longitude' => ['required', 'max:40'],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'message' => $validator->errors()->first(),
            ], 403);
        }

        $user = UsuariosLocation::find($id);

        $user->online = $request->online === 'true' ? true : false;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->update();

        return response()->json([
            'message' => 'actualizado'
        ], 200);
    }
}
