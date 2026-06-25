<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'       => ['required', 'string', 'email'],
            'password'    => ['required', 'string'],
            'device_name' => ['sometimes', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'An email address is required.',
            'email.email'       => 'Please provide a valid email address.',
            'password.required' => 'A password is required.',
        ];
    }
}
