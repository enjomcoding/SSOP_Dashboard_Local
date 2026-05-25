<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryTruckLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'truck_plate_no' => ['required', 'string', 'max:20'],
            'driver_name' => ['required', 'string', 'max:100'],
            'checked_by_name' => ['required', 'string', 'max:255'],
            'inspection_date' => ['required', 'date'],
            'inspection_time' => ['required', 'date_format:H:i:s'],
            'exterior_condition' => ['required', Rule::in(['CLEAN', 'DIRTY'])],
            'interior_condition' => ['required', Rule::in(['CLEAN', 'DIRTY'])],
            'odor' => ['required', Rule::in(['NORMAL', 'UNUSUAL'])],
            'pest_activity' => ['sometimes', 'boolean'],
            'sanitized' => ['sometimes', 'boolean'],
            'maintenance_issues' => ['sometimes', 'boolean'],
            'corrective_action' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('inspection_time') && preg_match('/^\d{2}:\d{2}$/', $this->inspection_time)) {
            $this->merge(['inspection_time' => $this->inspection_time . ':00']);
        }

    }
}
