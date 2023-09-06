<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Devices\UpdateDeviceKeyRequest;
use App\Http\Resources\Users\UserDeviceResource;
use App\Models\UserDevice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceController extends Controller
{

    public function push(Request $request): JsonResponse
    {
        /**
         * Variables del request
         *  - Device Keys
         */
        $url = env('PUSH_URL'); // Variable .env para la url del metodo push notification
        $serverKey = env('PUSH_SERVER_KEY'); // Variable .env para el server key generado en el proyecto de firebase

        /** Variables de los devices para el push */
        $deviceKeys = $request->input('deviceKeys');

        $data = [
            "registration_ids" => $deviceKeys,
            "notification" => [
                "body" => $request->input('notification')['body'],
                "title" => $request->input('notification')['title']
            ],
            "priority" => $request->input('priority'),
            "data" => [
                "product" => $request->input('data')['product']
            ]
        ];

        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response

        return $this->sendResponse([], 'Notificación Push enviada exitosamente!');
    }


    public function updateKey(UpdateDeviceKeyRequest $request): JsonResponse
    {
        $userDevice = UserDevice::create([
            'user_id' => $request->get('user_id'),
            'user_device_key' => $request->get('user_device_key')
        ]);

        $resource = new UserDeviceResource($userDevice);
        return $this->sendResponse($resource, 'Actualización del device key para el usuario exitosa');
    }

    public function getAllKeys(): JsonResponse
    {
        $keys = UserDevice::all();
        return $this->sendResponse($keys, 'Todos los keys obtenidos exitosamente');
    }


    public function getUserKeys(int $id): JsonResponse
    {
        $keys = UserDevice::where('user_id', $id)->get();

        if ($keys->isEmpty()) {
            return $this->sendError('Este usuario no tiene ningún device key asociado');
        }

        return $this->sendResponse($keys, 'Device keys del usuario obtenidas exitosamente');
    }
}
