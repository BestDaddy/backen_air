<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArduinoType extends Model
{
    protected $fillable = [
        'name',
        'class',
    ];

    public const AIR_ID = 1;
    public $timestamps = false;
}
