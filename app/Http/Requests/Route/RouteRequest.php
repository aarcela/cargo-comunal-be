<?php

namespace App\Http\Requests\Route;

use App\Concerns\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class RouteRequest extends FormRequest
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
                'nombre' => 'sometimes|nullable|string',
                'description' => 'sometimes|nullable|string',
            ];
        } else {
            $rules = [
                'nombre' => 'sometimes|nullable|string',
                'description' => 'sometimes|nullable|string',
            ];
        }

        return $rules;
    }
}
