<?php

namespace App\Services\Arduino;

use App\Models\Arduino;
use App\Models\Minion;
use App\Services\BaseServiceImpl;

class ArduinoServiceImpl extends BaseServiceImpl implements ArduinoService
{
    public function __construct(Arduino $model)
    {
        parent::__construct($model);
    }

    public function auth($ip, $type)
    {
        return $this->model->where('ip', $ip)->where('type_id', $type)->first();
    }
}
