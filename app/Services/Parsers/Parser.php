<?php

namespace App\Services\Parsers;

interface Parser
{
    public function execute($log_id);

    public function getModel();
}
