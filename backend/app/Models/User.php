<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;
    protected $fillable = [
        'full_name',
        'initials',
        'role',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
