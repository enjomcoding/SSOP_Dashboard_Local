<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawMaterialLog extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'raw_material_logs';

    protected $fillable = [
        'supplier_name',
        'agreed_scheduled_date',
        'receiving_date',
        'time_received',
        'delivery_vehicle_id',
        'qc_inspector',
        'raw_material',
        'packaging_condition',
        'moisture_content_or_expiry',
        'within_specs',
        'quantity',
        'status',
        'inspector_initials',
        'received_by',
    ];

    protected $casts = [
        'agreed_scheduled_date' => 'date',
        'receiving_date' => 'date',
        'within_specs' => 'boolean',
        'quantity' => 'decimal:2',
    ];
}
