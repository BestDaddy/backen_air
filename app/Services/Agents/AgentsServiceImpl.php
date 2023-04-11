<?php

namespace App\Services\Agents;

use App\Models\Agent;
use App\Services\BaseServiceImpl;

class AgentsServiceImpl extends BaseServiceImpl implements AgentsService
{
    public function __construct(Agent $model)
    {
        parent::__construct($model);
    }
}
