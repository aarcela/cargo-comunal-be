<?php

namespace App\Http\Requests\Transports;

use App\Concerns\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class TemporaryTransportUpdateRequest extends FormRequest
{
    use FailedValidation;
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
    public function rules()
    {
        return [
            'estado' => 'required|string',
        ];
    }
}
