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
}
