<?php

namespace App\Services\Parsers;

class AirParser implements Parser
{
    private $log_id;
    public function __construct( $log_id)
    {
        $this->log_id = $log_id;
    }

    public function execute()
    {

    }
}
