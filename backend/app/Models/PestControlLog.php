<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PestControlLog extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'pest_control_logs';

    protected $fillable = [
        'inspection_date',
        'inspector_name',
        'inspection_area',
        'pest_activity_observed',
        'type_of_pest',
        'corrective_action_taken',
        'inspector_initials',
        'verified_by_qa',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'pest_activity_observed' => 'boolean',
    ];
}
