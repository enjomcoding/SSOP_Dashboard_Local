<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RawMaterialLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
            'supplier' => ['required', 'string', 'max:150'],
            'agreed_scheduled_date' => ['nullable', 'date'],
            'receiving_date' => ['required', 'date'],
            'time_received' => ['required', 'date_format:H:i:s'],
            'delivery_vehicle_id' => ['nullable', 'string', 'max:80'],
            'qc_inspector_name' => ['required', 'string', 'max:255'],
            'raw_material' => ['required', 'string', 'max:150'],
            'packaging_condition' => ['required', Rule::in(['GOOD', 'DAMAGED'])],
            'moisture_content_or_expiry' => ['nullable', 'string', 'max:150'],
            'within_specs' => ['sometimes', 'boolean'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['ACCEPTED', 'REJECTED'])],
            'received_by_name' => ['required', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('time_received') && preg_match('/^\d{2}:\d{2}$/', $this->time_received)) {
            $this->merge(['time_received' => $this->time_received . ':00']);
        }
    }
}
