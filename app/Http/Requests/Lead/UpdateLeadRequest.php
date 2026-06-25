<?php

namespace App\Http\Requests\Lead;

use App\Enums\LeadStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['sometimes', 'string', 'max:255'],
            'email'       => ['sometimes', 'email', 'max:255'],
            'phone'       => ['sometimes', 'string', 'max:30'],
            'status'      => ['sometimes', Rule::enum(LeadStatus::class)],
            'assigned_to' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
        ];
    }
}
