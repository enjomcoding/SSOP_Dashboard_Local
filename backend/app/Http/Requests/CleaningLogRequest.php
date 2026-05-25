<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CleaningLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'log_date' => ['required', 'date'],
            'log_time' => ['required', 'date_format:H:i:s'],
            'area_of_concern' => ['required', 'string', 'max:150'],
            'standard_met' => ['sometimes', 'boolean'],
            'action_taken' => ['nullable', 'string'],
            'sanitizer_used' => ['nullable', 'string', 'max:100'],
            'performed_by' => ['required', 'string', 'max:100'],
            'checked_by' => ['nullable', 'string', 'max:100'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('log_time') && preg_match('/^\d{2}:\d{2}$/', $this->log_time)) {
            $this->merge(['log_time' => $this->log_time . ':00']);
        }
    }
}
