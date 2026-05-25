<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CleaningLog extends Model
{
    use HasFactory;
    public const UPDATED_AT = null;

    public const RELATIONS = [];

    protected $table = 'cleaning_logs';

    protected $fillable = [
        'log_date',
        'log_time',
        'area_of_concern',
        'standard_met',
        'action_taken',
        'sanitizer_used',
        'performed_by_name',
        'checked_by_name',
    ];

    protected $casts = [
        'log_date' => 'date',
        'standard_met' => 'boolean',
    ];

}
