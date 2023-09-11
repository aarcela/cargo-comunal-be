<?php

namespace App\Http\Requests\Viajes;

use Illuminate\Foundation\Http\FormRequest;

class ViajesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules = [
                'user_id' => 'required|max:40|exists:users,id',
                'transport_id' => 'required|max:40|exists:transports,id',
                'ruta' => 'required|string',
                'tiempo' => 'required|string',
                'hora' => 'nullable',
                'peso' => 'required|string',
                'status' => 'required|string',
                'latitud_origen' => 'required|string',
                'longitud_origen' => 'required|string',
                'latitud_destino' => 'required|string',
                'longitud_destino' => 'required|string'
            ];
        } else {
            $rules = [
                'user_id' => 'required|max:40|exists:users,id',
                'transport_id' => 'required|max:40|exists:transports,id',
                'ruta' => 'required|string',
                'tiempo' => 'required|string',
                'hora' => 'nullable',
                'peso' => 'required|string',
                'status' => 'required|string',
                'latitud_origen' => 'required|string',
                'longitud_origen' => 'required|string',
                'latitud_destino' => 'required|string'
            ];
        }

        return $rules;
    }
}
