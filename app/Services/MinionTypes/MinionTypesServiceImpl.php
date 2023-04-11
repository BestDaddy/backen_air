<?php

namespace App\Services\MinionTypes;

use App\Models\MinionType;
use App\Services\BaseServiceImpl;

class MinionTypesServiceImpl extends BaseServiceImpl implements MinionTypesService
{
    public function __construct(MinionType $model)
    {
        parent::__construct($model);
    }
}
