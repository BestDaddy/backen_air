<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arduino extends Model
{
    protected $table = 'arduino';

    protected $fillable = [
        'type_id',
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

    protected $hidden = [
        'token'
    ];

    public function type() {
        return $this->belongsTo(ArduinoType::class, 'type_id', 'id', 'arduino_types');
    }

    public function logs() {
        return $this->hasMany(Log::class, 'arduino_id', 'id');
    }
}
