<?php

namespace App\Http\Requests\Lead;

use Illuminate\Foundation\Http\FormRequest;

class AssignLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'assigned_to' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'assigned_to.required' => 'A user must be specified for assignment.',
            'assigned_to.exists'   => 'The specified user does not exist.',
        ];
    }
}
