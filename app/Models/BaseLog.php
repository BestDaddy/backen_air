<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseLog extends Model
{
    use HasFactory;

    protected $table = 'base_logs';
    protected $fillable = [
        'log_id',
        'ppm',
    ];

    public function log() {
        return $this->belongsTo(Log::class);
    }
}
