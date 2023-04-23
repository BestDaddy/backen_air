<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'minion_id',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function agent() {
        return $this->belongsTo(Agent::class);
    }

    public function minion() {
        return $this->belongsTo(Minion::class);
    }
}