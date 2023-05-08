<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
//    use HasFactory;

    protected $fillable = [
        'arduino_id',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function arduino() {
        return $this->belongsTo(Arduino::class);
    }
}
