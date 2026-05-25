<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OilTemperatureLog extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'oil_temperature_logs';

    protected $fillable = [
        'production_date',
        'batch_lot_no',
        'operator_name_id',
        'time_checked',
        'oil_temperature_c',
        'operator_initial',
        'corrective_action',
        'verified_by_qa',
    ];

    protected $casts = [
        'production_date' => 'date',
        'oil_temperature_c' => 'decimal:2',
    ];
}
