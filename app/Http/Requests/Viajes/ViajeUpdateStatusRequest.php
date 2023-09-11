<?php

namespace App\Http\Requests\Viajes;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $status
 */
class ViajeUpdateStatusRequest extends FormRequest
{
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
            'status' => 'required|string',
        ];
    }
}
