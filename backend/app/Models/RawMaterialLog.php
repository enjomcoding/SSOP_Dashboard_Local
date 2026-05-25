<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RawMaterialLog extends Model
{
    use HasFactory;
    public const UPDATED_AT = null;

    public const RELATIONS = [];

    protected $table = 'raw_material_logs';

    protected $fillable = [
        'supplier',
        'agreed_scheduled_date',
        'receiving_date',
        'time_received',
        'delivery_vehicle_id',
        'qc_inspector_name',
        'raw_material',
        'packaging_condition',
        'moisture_content_or_expiry',
        'within_specs',
        'quantity',
        'status',
        'received_by_name',
    ];

    protected $casts = [
        'agreed_scheduled_date' => 'date',
        'receiving_date' => 'date',
        'within_specs' => 'boolean',
        'quantity' => 'decimal:2',
    ];

}
