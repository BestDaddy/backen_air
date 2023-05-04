<?php

namespace App\Services\Minions;

use App\Models\Minion;
use App\Services\BaseServiceImpl;

class MinionsServiceImpl extends BaseServiceImpl implements MinionsService
{
    public function __construct(Minion $model)
    {
        parent::__construct($model);
    }

    public function auth($ip, $type)
    {
        return Minion::where('minion_type_id', $type)->whereHas('agent', function ($q) use ($ip) {
            $q->where('ip', $ip);
        })->first();
    }
}
