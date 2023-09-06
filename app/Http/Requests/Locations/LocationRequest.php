<?php

namespace App\Http\Requests\Locations;

use App\Concerns\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
    public function rules(): array
    {
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules = [
                'user_id' => 'required|max:40|exists:usuarios,id',
                'online' => 'required|boolean',
                'latitude' => 'required|string|max:40',
                'longitude' => 'required|string|max:40',
            ];
        } else {
            $rules = [
                'user_id' => 'required|max:40|exists:usuarios,id',
                'latitude' => 'required|string|max:40',
                'longitude' => 'required|string|max:40',
            ];
        }

        return $rules;

    }
}
