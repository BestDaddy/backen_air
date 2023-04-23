<?php

namespace App\Services\Parsers;

interface Parser
{
    public function __construct($log_id);
    public function execute();
}
