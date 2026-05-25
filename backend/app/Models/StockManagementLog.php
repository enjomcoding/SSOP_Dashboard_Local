<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockManagementLog extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'stock_management_logs';

    protected $fillable = [
        'warehouse_location',
        'checked_by',
        'log_date',
        'log_time',
        'product_name',
        'batch_lot_no',
        'quantity_in_stock',
        'expiry_date',
        'storage_condition',
        'fifo_fefo_followed',
        'inspector_initials',
        'corrective_action',
    ];

    protected $casts = [
        'log_date' => 'date',
        'expiry_date' => 'date',
        'quantity_in_stock' => 'decimal:2',
        'fifo_fefo_followed' => 'boolean',
    ];
}
