<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'initials',
        'role',
    ];

    public function qcRawMaterialLogs(): HasMany
    {
        return $this->hasMany(RawMaterialLog::class, 'qc_inspector_id');
    }

    public function receivedRawMaterialLogs(): HasMany
    {
        return $this->hasMany(RawMaterialLog::class, 'received_by_id');
    }
}
