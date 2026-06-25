<?php

namespace App\Http\Requests\Note;

use Illuminate\Foundation\Http\FormRequest;

class CreateNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'note' => ['required', 'string', 'min:1', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'note.required' => 'Note content is required.',
            'note.max'      => 'Note content must not exceed 5000 characters.',
        ];
    }
}
