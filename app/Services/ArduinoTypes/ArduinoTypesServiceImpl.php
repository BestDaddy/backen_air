<?php

namespace App\Services\ArduinoTypes;

use App\Models\ArduinoType;
use App\Services\BaseServiceImpl;

class ArduinoTypesServiceImpl extends BaseServiceImpl implements ArduinoTypesService
{
    public function __construct(ArduinoType $model)
    {
        parent::__construct($model);
    }
}
