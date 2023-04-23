<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minion extends Model
{
    protected $fillable = [
        'agent_id',
        'minion_type_id',
        'token',
        'expired_at',
    ];

    protected $hidden = [
        'token',
//        'expired_at'
    ];

    public function agent() {
        return $this->belongsTo(Agent::class);
    }

    public function minionType() {
        return $this->belongsTo(MinionType::class);
    }
}
