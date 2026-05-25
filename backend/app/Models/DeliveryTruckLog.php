<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryTruckLog extends Model
{
    use HasFactory;
    public const UPDATED_AT = null;

    public const RELATIONS = [];

    protected $table = 'delivery_truck_logs';

    protected $fillable = [
        'truck_plate_no',
        'driver_name',
        'checked_by_name',
        'inspection_date',
        'inspection_time',
        'exterior_condition',
        'interior_condition',
        'odor',
        'pest_activity',
        'sanitized',
        'maintenance_issues',
        'corrective_action',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'pest_activity' => 'boolean',
        'sanitized' => 'boolean',
        'maintenance_issues' => 'boolean',
    ];

}
