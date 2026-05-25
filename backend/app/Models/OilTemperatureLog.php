<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OilTemperatureLog extends Model
{
    use HasFactory;
    public const UPDATED_AT = null;

    public const RELATIONS = [];

    protected $table = 'oil_temperature_logs';

    protected $fillable = [
        'production_date',
        'batch_lot_no',
        'operator_name',
        'time_checked',
        'oil_temperature_c',
        'corrective_action',
        'verified_by_qa_name',
    ];

    protected $casts = [
        'production_date' => 'date',
        'oil_temperature_c' => 'decimal:2',
    ];

}
