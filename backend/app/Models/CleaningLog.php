<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CleaningLog extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'cleaning_logs';

    protected $fillable = [
        'log_date',
        'log_time',
        'area_of_concern',
        'standard_met',
        'action_taken',
        'sanitizer_used',
        'performed_by',
        'checked_by',
    ];

    protected $casts = [
        'log_date' => 'date',
        'standard_met' => 'boolean',
    ];
}
