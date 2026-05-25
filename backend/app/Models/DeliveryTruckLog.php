<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryTruckLog extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'delivery_truck_logs';

    protected $fillable = [
        'truck_plate_no',
        'driver_name',
        'checked_by',
        'inspection_date',
        'inspection_time',
        'exterior_condition',
        'interior_condition',
        'odor',
        'pest_activity',
        'sanitized',
        'maintenance_issues',
        'inspector_initials',
        'corrective_action',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'pest_activity' => 'boolean',
        'sanitized' => 'boolean',
        'maintenance_issues' => 'boolean',
    ];
}
