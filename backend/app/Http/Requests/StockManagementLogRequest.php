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
            'checked_by_name' => ['required', 'string', 'max:255'],
            'log_date' => ['required', 'date'],
            'log_time' => ['required', 'date_format:H:i:s'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'batch_lot_no' => ['required', 'string', 'max:80'],
            'quantity_in_stock' => ['required', 'numeric', 'min:0'],
            'expiry_date' => ['nullable', 'date'],
            'storage_condition' => ['required', Rule::in(['GOODS', 'NEEDS ATTENTION'])],
            'fifo_fefo_followed' => ['sometimes', 'boolean'],
            'corrective_action' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('log_time') && preg_match('/^\d{2}:\d{2}$/', $this->log_time)) {
            $this->merge(['log_time' => $this->log_time . ':00']);
        }

        foreach (['product_id'] as $field) {
            if ($this->has($field) && $this->$field !== null && $this->$field !== '') {
                $this->merge([$field => (int) $this->$field]);
            }
        }
    }
}
