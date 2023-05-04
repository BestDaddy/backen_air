<?php

namespace App\Services\Logs;

use App\Models\Log;
use App\Services\BaseServiceImpl;

class LogsServiceImpl  extends BaseServiceImpl implements LogsService
{
    public function __construct(Log $model)
    {
        parent::__construct($model);
    }
}
