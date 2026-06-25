<?php

namespace App\Http\Requests\Lead;

use App\Enums\LeadStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255'],
            'phone'       => ['required', 'string', 'max:30'],
            'status'      => ['sometimes', Rule::enum(LeadStatus::class)],
            'assigned_to' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Lead name is required.',
            'email.required' => 'Lead email is required.',
            'email.email'    => 'Please provide a valid email address.',
            'phone.required' => 'Lead phone number is required.',
            'status.enum'    => 'Status must be one of: new, contacted, converted.',
        ];
    }
}
