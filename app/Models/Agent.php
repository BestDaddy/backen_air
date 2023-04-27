<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'name',
        'ip',
        'token',
        'expired_at',
        'last_seen_at',
        'config',
    ];

    protected $casts = [
        'config' => 'array',
    ];

    public function minions() {
        return $this->hasMany(Minion::class);
    }

    public function minion() {
        return $this->hasOne(Minion::class);
    }
}
