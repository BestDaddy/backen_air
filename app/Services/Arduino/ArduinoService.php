<?php

namespace App\Services\Arduino;

use App\Services\BaseService;

interface ArduinoService extends BaseService
{
    public function auth($ip , $type);
}
