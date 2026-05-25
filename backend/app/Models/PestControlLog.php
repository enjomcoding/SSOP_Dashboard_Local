<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PestControlLog extends Model
{
    use HasFactory;
    public const UPDATED_AT = null;

    public const RELATIONS = [];

    protected $table = 'pest_control_logs';

    protected $fillable = [
        'inspection_date',
        'inspector_name',
        'inspection_area',
        'pest_activity_observed',
        'type_of_pest',
        'corrective_action_taken',
        'verified_by_qa_name',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'pest_activity_observed' => 'boolean',
    ];

}
