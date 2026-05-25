<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockManagementLog extends Model
{
    use HasFactory;
    public const UPDATED_AT = null;

    public const RELATIONS = ['product'];

    protected $table = 'stock_management_logs';

    protected $fillable = [
        'warehouse_location',
        'checked_by_name',
        'log_date',
        'log_time',
        'product_id',
        'batch_lot_no',
        'quantity_in_stock',
        'expiry_date',
        'storage_condition',
        'fifo_fefo_followed',
        'corrective_action',
    ];

    protected $casts = [
        'log_date' => 'date',
        'expiry_date' => 'date',
        'quantity_in_stock' => 'decimal:2',
        'fifo_fefo_followed' => 'boolean',
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
