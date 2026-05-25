<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockManagementLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_location' => ['required', 'string', 'max:150'],
            'checked_by' => ['required', 'string', 'max:100'],
            'log_date' => ['required', 'date'],
            'log_time' => ['required', 'date_format:H:i:s'],
            'product_name' => ['required', 'string', 'max:150'],
            'batch_lot_no' => ['required', 'string', 'max:80'],
            'quantity_in_stock' => ['required', 'numeric', 'min:0'],
            'expiry_date' => ['nullable', 'date'],
            'storage_condition' => ['required', Rule::in(['GOODS', 'NEEDS ATTENTION'])],
            'fifo_fefo_followed' => ['sometimes', 'boolean'],
            'inspector_initials' => ['required', 'string', 'max:10'],
            'corrective_action' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('log_time') && preg_match('/^\d{2}:\d{2}$/', $this->log_time)) {
            $this->merge(['log_time' => $this->log_time . ':00']);
        }
    }
}
