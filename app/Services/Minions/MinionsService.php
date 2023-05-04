<?php

namespace App\Services\Minions;

use App\Services\BaseService;

interface MinionsService extends BaseService
{
    public function auth($ip, $type);
}
