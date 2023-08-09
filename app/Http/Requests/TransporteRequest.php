<?php

namespace App\Http\Requests;

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
            'nro_placa' => 'required|max:20|unique:usuarios_transportes,nro_placa',
            'marca' => 'required|max:20|string',
            'modelo' => 'required|max:20|string',
            'carnet_circulacion' => 'required|max:20|unique:usuarios_transportes,carnet_circulacion',
            'carga_maxima' => 'required|max:20',
            'id_user' => 'required',
        ];
    }
}
