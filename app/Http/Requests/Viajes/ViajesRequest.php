<?php

namespace App\Http\Requests\Viajes;

use App\Concerns\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class ViajesRequest extends FormRequest
{
    use FailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
                'user_id' => 'sometimes|nullable|exists:users,id',
                'transport_id' => 'sometimes|nullable|exists:transports,id',
                'ruta' => 'sometimes|nullable|string',
                'tiempo' => 'sometimes|nullable|string',
                'hora' => 'nullable',
                'peso' => 'sometimes|nullable|string',
                'latitud_origen' => 'sometimes|nullable|string',
                'longitud_origen' => 'sometimes|nullable|string',
                'latitud_destino' => 'sometimes|nullable|string',
                'longitud_destino' => 'sometimes|nullable|string'
            ];
        } else {
            $rules = [
                'user_id' => 'required|max:40|exists:users,id',
                'transport_id' => 'required|max:40|exists:transports,id',
                'ruta' => 'required|string',
                'tiempo' => 'required|string',
                'hora' => 'nullable',
                'peso' => 'required|string',
                'latitud_origen' => 'nullable|string',
                'longitud_origen' => 'nullable|string',
                'latitud_destino' => 'nullable|string',
                'longitud_destino' => 'nullable|string'
            ];
        }

        return $rules;
    }
}
