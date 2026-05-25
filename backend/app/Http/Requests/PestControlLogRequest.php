<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PestControlLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'inspection_date' => ['required', 'date'],
            'inspector_name' => ['required', 'string', 'max:100'],
            'inspection_area' => ['required', 'string', 'max:150'],
            'pest_activity_observed' => ['sometimes', 'boolean'],
            'type_of_pest' => ['nullable', 'string', 'max:100'],
            'corrective_action_taken' => ['nullable', 'string'],
            'inspector_initials' => ['required', 'string', 'max:10'],
            'verified_by_qa' => ['nullable', 'string', 'max:100'],
        ];
    }
}
