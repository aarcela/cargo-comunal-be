<?php

namespace App\Http\Requests\Users;

use App\Concerns\Traits\FailedValidation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            $id = intVal(request()->segment(3));
            $profile_id = User::find($id)->profile->id;
            $rules = [
                'username' => ['sometimes', 'nullable', 'regex:/^[a-zA-Z0-9_]+$/', 'max:15', Rule::unique('usuarios', 'username')->ignore($id)],
                'email' => ['sometimes', 'nullable', 'email', Rule::unique('usuarios', 'email')->ignore($id)],
                'password' => 'sometimes|nullable|string',
                'role' => 'sometimes|nullable|string',
                'first_name' => 'sometimes|nullable|string',
                'second_name' => 'sometimes|nullable|string',
                'first_surname' => 'sometimes|nullable|string',
                'second_surname' => 'sometimes|nullable|string',
                'phone' => 'sometimes|nullable|string',
                'ci' => ['sometimes', 'nullable', 'regex:/^[0-9]+$/', 'max:12', Rule::unique('profiles', 'ci')->ignore($profile_id)],
                'fecha_nc' => 'sometimes|nullable|date',
            ];

            /*if ($this->has('password')) {
                $rules['password'] = 'nullable|string|min:6|confirmed';
            }*/
        } else {
            $rules = [
                'username' => ['required', 'regex:/^[a-zA-Z0-9_]+$/', 'max:15', 'unique:usuarios,username'],
                'email' => ['required', 'email', 'unique:usuarios'],
                'password' => ['required', 'min:6'],
                'role' => ['required'],
                'first_name' => ['required', 'string'],
                'second_name' => ['nullable', 'string'],
                'first_surname' => ['required', 'string'],
                'second_surname' => ['nullable', 'string'],
                'phone' => ['required', 'regex:/^[0-9]+$/', 'max:11'],
                'ci' => ['required', 'regex:/^[0-9]+$/', 'max:12', 'unique:profiles,ci'],
                'fecha_nc' => ['required'],
            ];
        }

        return $rules;
    }
}
