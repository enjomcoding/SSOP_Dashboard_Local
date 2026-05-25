<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OilTemperatureLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'production_date' => ['required', 'date'],
            'batch_lot_no' => ['required', 'string', 'max:80'],
            'operator_name' => ['required', 'string', 'max:255'],
            'time_checked' => ['required', 'date_format:H:i:s'],
            'oil_temperature_c' => ['required', 'numeric'],
            'corrective_action' => ['nullable', 'string'],
            'verified_by_qa_name' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('time_checked') && preg_match('/^\d{2}:\d{2}$/', $this->time_checked)) {
            $this->merge(['time_checked' => $this->time_checked . ':00']);
        }

    }
}
