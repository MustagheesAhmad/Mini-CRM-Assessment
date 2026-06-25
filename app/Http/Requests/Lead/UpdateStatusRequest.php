<?php

namespace App\Http\Requests\Lead;

use App\Enums\LeadStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(LeadStatus::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'A status value is required.',
            'status.enum'     => 'Status must be one of: new, contacted, converted.',
        ];
    }
}
