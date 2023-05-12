<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseLog extends Model
{
    use HasFactory;

    protected $table = 'base_logs';
    protected $fillable = [
        'arduino_id',
        'log_id',
        'ppm',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function log() {
        return $this->belongsTo(Log::class);
    }

    public function arduino() {
        return $this->belongsTo(Arduino::class);
    }
}
