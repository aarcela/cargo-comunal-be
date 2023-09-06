<?php

namespace App\Http\Requests\Transports;

use App\Concerns\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class TransporteRequest extends FormRequest
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
        return [
            'user_id' => 'required|exists:users,id',
            'nro_placa' => 'required|max:20|unique:transports,nro_placa',
            'marca' => 'required|max:20|string',
            'modelo' => 'required|max:20|string',
            'carnet_circulacion' => 'required|max:20|unique:transports,carnet_circulacion',
            'carga_maxima' => 'required|max:20',
            'tipo' => 'nullable|max:36'
        ];
    }
}
